<?php
use App\Connection;
use App\Table\CommentTable;
use App\Auth;

Auth::check();
$router->layout = 'admin/layouts/default';
$title = "Gestion des commentaires";
$pdo = Connection::getPDO();


$commentTable = new CommentTable($pdo);

$commentTable->initCommentStatus();


$comments = $commentTable->findPending();
?>

<h1>Gestion des commentaires</h1>

<?php if (isset($_GET['approved']) && $_GET['approved'] == 1): ?>
    <div class="alert alert-success">
        Le commentaire a été approuvé.
    </div>
<?php endif; ?>

<?php if (isset($_GET['rejected']) && $_GET['rejected'] == 1): ?>
    <div class="alert alert-danger">
        Le commentaire a été rejeté.
    </div>
<?php endif; ?>

<?php if (empty($comments)): ?>
    <div class="alert alert-info">
        Aucun commentaire en attente de modération.
    </div>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Article</th>
                <th>Contenu</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?= $comment->getId() ?></td>
                    <td>
                        <?php if (isset($comment->article_title)): ?>
                            <a href="<?= $router->url('post', ['id' => $comment->getArticleId()]) ?>">
                                <?= htmlentities($comment->article_title) ?>
                            </a>
                        <?php else: ?>
                            Article #<?= $comment->getArticleId() ?>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlentities(mb_substr($comment->getContenu(), 0, 100)) ?>...</td>
                    <td>
                        <?php 
                        $dateTime = $comment->getCreatedAt();
                        echo $dateTime->format('d/m/Y H:i'); 
                        ?>
                    </td>
                    <td class="d-flex">
                        <form action="<?= $router->url('admin_comment_approve', ['id' => $comment->getId()]) ?>" method="post" style="margin-right: 5px;">
                            <button type="submit" class="btn btn-sm btn-success">Approuver</button>
                        </form>
                        <form action="<?= $router->url('admin_comment_reject', ['id' => $comment->getId()]) ?>" method="post">
                            <button type="submit" class="btn btn-sm btn-danger">Rejeter</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
