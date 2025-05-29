<?php

use App\Connection;
use App\Model\Post;
use App\Model\Category;
use App\Helpers\URL;
use App\Table\PostTable;
use App\Table\CategoryTable;
use App\PaginatedQuery;
use App\Table\Table;

$id = (int)$params['id'];
$pdo = Connection::getPDO();
$table = new PostTable($pdo); 
// $query = $pdo->prepare('SELECT * FROM article WHERE id = :id');
// $query->execute(['id' => $id]);
// $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
// /**@var Post|false */
// $post = $query->fetch();
// if ($post === false) {
//     throw new Exception('Aucun article ne correspond à cet identifiant');
// }

$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

// $query = $pdo->prepare('
// SELECT c.id, c.name
// FROM article_category ac
//     JOIN category c ON ac.category_id = c.id
//     WHERE ac.article_id = :id
// ');

// $query->execute(['id' => $post->getID()]);
// $query->setFetchMode(PDO::FETCH_CLASS, \App\Model\Category::class);
// $categories = $query->fetchAll();

$author = null;
if (method_exists($post, 'getAuthorId')) {
    $authorQuery = $pdo->prepare('SELECT nom, prenom FROM user WHERE id = :id');
    $authorQuery->execute(['id' => $post->getAuthorId()]);
    $author = $authorQuery->fetch();
}


?>
<h1 class="card-title"><?= htmlentities($post->getName()) ?></h1>

<!-- Catégorie de l'article -->
<?php foreach ($post->getCategories() as $k => $category): ?>
    <?php if($k > 0): echo ', '; endif; ?>
    <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>"
       class="badge bg-secondary text-decoration-none">
        <?= htmlentities($category->getName()) ?>
    </a>
<?php endforeach; ?>
<!-- Fin de catégorie de l'article -->


<p class="card-text"><?= $post->getChapo() ?></p>

<p class="text-muted">
    <?php
    $dateTime = $post->getCreatedAt();
    $formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::SHORT,
        null,
        null,
        'd MMMM y HH\'h\'mm'
    );
    echo $formatter->format($dateTime);
    ?>
</p>




<p><?= $post->getFormattedContent() ?></p>

<p class="text-end text-secondary">
    <em>
        Auteur :
        <?php if ($author): ?>
            <?= htmlentities($author['prenom'] . ' ' . $author['nom']) ?>
        <?php else: ?>
            Inconnu
        <?php endif; ?>
    </em>
</p>

<hr class="my-5">

<!-- Section des commentaires -->
<div class="comment-section">
    <!-- Affichage des commentaires validés -->
    <h3>Commentaires</h3>
    
    <?php
   
    $commentTable = new \App\Table\CommentTable($pdo);
   
    $commentTable->initCommentStatus();
    $comments = $commentTable->findForArticle($post->getId());
    ?>
    
    <?php if (!empty($comments)): ?>
        <div class="comments-list mb-5">
            <?php foreach ($comments as $comment): ?>
                <div class="comment card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($comment->getNom() ?? 'Anonyme') ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <?php
                            $dateTime = $comment->getCreatedAt();
                            $formatter = new IntlDateFormatter(
                                'fr_FR',
                                IntlDateFormatter::LONG,
                                IntlDateFormatter::SHORT,
                                null,
                                null,
                                'd MMMM y HH\'h\'mm'
                            );
                            echo $formatter->format($dateTime);
                            ?>
                        </h6>
                        <p class="card-text"><?= $comment->getFormattedContenu() ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>

    <?php endif; ?>
    

    <div class="comment-form">
        <h3>Ajouter un commentaire</h3>
        <h5 class="text-muted mb-3">Ajoutez votre commentaire</h5>
        
        <?php if (isset($_GET['comment_added']) && $_GET['comment_added'] == 1): ?>
            <div class="alert alert-success">
                Votre commentaire a bien été envoyé et sera publié une fois validé.
            </div>
        <?php endif; ?>
        
        <form action="<?= $router->url('post_comment', ['id' => $post->getId()]) ?>" method="POST">
            <div class="form-group mb-3">
                <input type="text" class="form-control" name="username" placeholder="Votre nom" required>
            </div>
            <div class="form-group mb-3">
                <textarea class="form-control" name="contenu" rows="4" placeholder="Votre message..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</div>

<!-- Script pour afficher le popup de confirmation -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
       
        if (window.location.search.includes('comment_added=1')) {
          
            var alertDiv = document.createElement('div');
            alertDiv.className = 'modal fade';
            alertDiv.id = 'commentModal';
            alertDiv.setAttribute('tabindex', '-1');
            alertDiv.setAttribute('aria-labelledby', 'commentModalLabel');
            alertDiv.setAttribute('aria-hidden', 'true');
            
            alertDiv.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentModalLabel">Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Votre commentaire a bien été envoyé et sera publié une fois validé.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                        </div>
                    </div>
                </div>`;
            
            document.body.appendChild(alertDiv);
            
          
            if (typeof jQuery === 'undefined') {
                var script = document.createElement('script');
                script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
                document.head.appendChild(script);
                
                script.onload = function() {
                    var bsScript = document.createElement('script');
                    bsScript.src = 'https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js';
                    document.head.appendChild(bsScript);
                    
                    bsScript.onload = function() {
                        $('#commentModal').modal('show');
                    };
                };
            } else {
                $('#commentModal').modal('show');
            }
            
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>
