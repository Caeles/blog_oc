<?php
namespace App\Table;

use App\PaginatedQuery;
use App\Model\Post;
use App\Model\Category;
use App\Table\Exception\NotFoundException;
use \PDO;

final class PostTable extends Table
{
        protected $table = 'article';
        protected $class = Post::class;
        
        
        
        protected $pdo;
        public function __construct__(PDO $pdo)
        {
            $this ->pdo = $pdo;
        }


        public function findPaginated(){
            $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM article ORDER BY created_at ASC",
            "SELECT COUNT(id) FROM article",
            $this->pdo
            );
            $posts = $paginatedQuery->getItems(Post::class);
            (new CategoryTable($this->pdo))->hydratePosts($posts);
            return [$posts,$paginatedQuery];
        }

        public function findPaginatedForCategory(int $categoryId)
        {
            $paginatedQuery = new PaginatedQuery(
                "SELECT a.*
                FROM article a
            JOIN article_category pc ON pc.article_id = a.id
            WHERE pc.category_id = {$categoryId}
            ORDER BY a.created_at DESC",
            "SELECT COUNT(category_id)
            FROM article_category
            WHERE category_id = {$categoryId}",
            $this->pdo
            );
            $posts = $paginatedQuery->getItems(Post::class);
            (new CategoryTable($this->pdo))->hydratePosts($posts);
            return [$posts,$paginatedQuery];
        }

           
        


        public function delete(int $id): void
        {
           $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
           $ok =$query->execute([$id]);
           if ($ok===false)
           {
            throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
           }
        }
        
      
        
        public function createPost(Post $post): void
    {
        $id = $this->create([
            'title' => $post->getTitle(),
            'chapo' => $post->getChapo(),
            'description' => $post->getDescription(),
            'author_id' => $post->getAuthorId(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s') 
        ]);
        $post->setId($id);
    }

    
       public function updatePost(Post $post): void
{
    $description = $post->getDescription();
    $description = preg_replace('/<\/?(?:br|BR)(?:\s|\/)?>/i', "\n", $description);
    $description = preg_replace('/\n+/', "\n", $description);
    
    $query = $this->pdo->prepare("UPDATE {$this->table} SET title = :title, chapo = :chapo, description = :description, author_id = :author_id WHERE id = :id");
    $ok = $query->execute([
        'title' => $post->getTitle(),
        'chapo' => $post->getChapo(),
        'description' => $description,
        'author_id' => $post->getAuthorId(),
        'id' => $post->getID()
    ]);
    if ($ok === false) {
        throw new \Exception("Impossible de modifier l'enregistrement {$post->getID()} dans la table {$this->table}");
    }
}
    /**
     * Associe les bonnes catégories à un article
     *
     * @param int $id L'id de l'article
     * @param Category[] $categories La liste des catégories
     * @return void
     */
      public function attachCategories(int $id, array $categories)
    {
        $this->pdo->exec('DELETE FROM article_category WHERE article_id = ' . $id);
        $query = $this->pdo->prepare('INSERT INTO article_category SET article_id = ?, category_id = ?');
        foreach ($categories as $category) {
            $query->execute([$id, $category]);
        }
    }
    }
   