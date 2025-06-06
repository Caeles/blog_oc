<?php
use App\Connection;
use App\Table\PostTable;
use App\Auth;

Auth::check();
$router->layout = 'admin/layouts/default';
$title="Administration";
$pdo=Connection::getPDO();
$link=$router->url('admin_posts');
[$posts, $pagination]=(new PostTable($pdo))->findPaginated();
?>


<?php if (isset($_GET['delete']) && $_GET['delete'] == 1): ?>
    <div class="alert alert-success">
        L'article a bien été supprimé.
    </div>
<?php endif; ?>
<table class="table ">
  
    <thead>
         <th>ID</th
        <th>Titre</th>
        <th>
            <a href="<?= $router->url('admin_post_new') ?>" class="btn btn-primary">Créer un article</a>
        </th>
    </thead>
    <tbody><?php foreach ($posts as $post): ?>
        <tr>
             <td>
                <?= $post->getID() ?>
                </a>
            </td>
            <td>
                <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?>">
                    <?= e($post->getName()) ?>
                </a>
            </td>
            <td>
                <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?>" class="btn btn-primary">Modifier</a>


                <form action="<?= $router->url('admin_post_delete', ['id' => $post->getID()]) ?>" method="POST" style="display:inline"
                onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')"    >
                <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
         </td>
        </tr>
        <?php endforeach; ?>    
    </tbody>
</table>

<div class="d-flex justify-content-between my-4">
    <?= $pagination -> previousLink($link); ?>
    <?= $pagination -> nextLink($link); ?>

  
</div>