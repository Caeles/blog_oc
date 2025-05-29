<?php
namespace App\Table;

use App\Model\Comment;
use App\Model\User;
use \PDO;
use App\Table\Exception\NotFoundException;

class CommentTable extends Table {

    protected $table = 'comment';
    protected $class = Comment::class;

    public function findForArticle(int $articleId): array
    {
        $publishedStatusId = 1;
        
        $statusQuery = $this->pdo->prepare("SELECT COUNT(*) FROM comment_status WHERE id = :id");
        $statusQuery->execute(['id' => $publishedStatusId]);
        $statusExists = (int)$statusQuery->fetchColumn() > 0;
        
        if (!$statusExists) {
          
            $statusQuery = $this->pdo->prepare("SELECT id FROM comment_status WHERE value = 'published'");
            $statusQuery->execute();
            $publishedId = $statusQuery->fetchColumn();
            
            if ($publishedId) {
                $publishedStatusId = $publishedId;
            }
        }

        $query = $this->pdo->prepare(
            "SELECT c.*, u.nom, u.prenom 
            FROM {$this->table} c
            JOIN user u ON c.user_id = u.id
            WHERE c.article_id = :article_id AND c.status_id = :status_id 
            ORDER BY c.created_at DESC"
        );
        $query->execute([
            'article_id' => $articleId,
            'status_id' => $publishedStatusId
        ]);
        
        $comments = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $comment = new \App\Model\Comment();
            $comment->setId($row['id']);
            $comment->setArticleId($row['article_id']);
            $comment->setUserId($row['user_id']);
            $comment->setStatusId($row['status_id']);
            $comment->setContenu($row['contenu']);
            $comment->setCreatedAt($row['created_at']);
            $comment->setUsername($row['prenom'] . ' ' . $row['nom']); 
            $comments[] = $comment;
        }
        
        return $comments;
    }


    public function findPending(): array
    {
   
        $statusQuery = $this->pdo->prepare("SELECT id FROM comment_status WHERE value = 'pending'");
        $statusQuery->execute();
        $pendingStatusId = $statusQuery->fetchColumn();

        if (!$pendingStatusId) {
            return [];
        }

        $query = $this->pdo->prepare(
            "SELECT c.*, a.title as article_title 
            FROM {$this->table} c
            JOIN article a ON c.article_id = a.id
            WHERE c.status_id = :status_id 
            ORDER BY c.created_at DESC"
        );
        $query->execute(['status_id' => $pendingStatusId]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        return $query->fetchAll();
    }

    public function createComment(int $articleId, string $contenu, int $userId = 0): bool
    {
     
        $statusQuery = $this->pdo->prepare("SELECT id FROM comment_status WHERE value = 'pending'");
        $statusQuery->execute();
        $pendingStatusId = $statusQuery->fetchColumn();

        if (!$pendingStatusId) {
            $insertStatus = $this->pdo->prepare("INSERT INTO comment_status (value) VALUES ('pending')");
            $insertStatus->execute();
            $pendingStatusId = $this->pdo->lastInsertId();
        }

        if ($userId === 0) {
            $anonymousQuery = $this->pdo->prepare("SELECT id FROM user WHERE email = 'anonymous@example.com'");
            $anonymousQuery->execute();
            $anonymousId = $anonymousQuery->fetchColumn();

            if (!$anonymousId) {
                $roleQuery = $this->pdo->prepare("SELECT id FROM role WHERE value = 'user'");
                $roleQuery->execute();
                $roleId = $roleQuery->fetchColumn() ?: 1;

                $statusQuery = $this->pdo->prepare("SELECT id FROM status WHERE value = 'active'");
                $statusQuery->execute();
                $statusId = $statusQuery->fetchColumn() ?: 1;

                $userInsert = $this->pdo->prepare(
                    "INSERT INTO user (nom, prenom, email, mot_de_passe, role_id, status_id) 
                    VALUES ('Anonymous', 'User', 'anonymous@example.com', :password, :role_id, :status_id)"
                );
                $userInsert->execute([
                    'password' => password_hash('anonymous', PASSWORD_DEFAULT),
                    'role_id' => $roleId,
                    'status_id' => $statusId
                ]);
                $userId = $this->pdo->lastInsertId();
            } else {
                $userId = $anonymousId;
            }
        }

        $query = $this->pdo->prepare(
            "INSERT INTO {$this->table} (article_id, user_id, status_id, contenu) 
            VALUES (:article_id, :user_id, :status_id, :contenu)"
        );
        return $query->execute([
            'article_id' => $articleId,
            'user_id' => $userId,
            'status_id' => $pendingStatusId,
            'contenu' => $contenu
        ]);
    }


    public function updateStatus(int $id, string $statusValue): bool
    {
        $statusQuery = $this->pdo->prepare("SELECT id FROM comment_status WHERE value = :value");
        $statusQuery->execute(['value' => $statusValue]);
        $statusId = $statusQuery->fetchColumn();

        if (!$statusId) {
            return false;
        }

        $query = $this->pdo->prepare("UPDATE {$this->table} SET status_id = :status_id WHERE id = :id");
        return $query->execute([
            'status_id' => $statusId, 
            'id' => $id
        ]);
    }

 
    public function initCommentStatus(): void
    {
        $statuses = ['pending', 'approved', 'rejected'];
        foreach ($statuses as $status) {
            $query = $this->pdo->prepare("SELECT COUNT(*) FROM comment_status WHERE value = :value");
            $query->execute(['value' => $status]);
            $exists = (int)$query->fetchColumn() > 0;

            if (!$exists) {
                $insertQuery = $this->pdo->prepare("INSERT INTO comment_status (value) VALUES (:value)");
                $insertQuery->execute(['value' => $status]);
            }
        }
    }
}
