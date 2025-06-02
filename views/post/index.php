<?php
use App\Helpers\Text;
use App\Model\Post;
use App\Connection;
use App\PaginatedQuery;
use App\Helpers\URL;
use App\Model\Category;
use App\Table\PostTable;    


$title="Blog";
$pdo=Connection::getPDO();

$table =new PostTable($pdo);
list($posts,$pagination)=$table->findPaginated();

$postsByID = [];
foreach ($posts as $post) {
    $postsByID[$post->getID()] = $post;
}

$categories = $pdo->query("SELECT c.*, pc.article_id
    FROM article_category pc
    JOIN category c ON c.id = pc.category_id
    WHERE pc.article_id IN (" . implode(',', array_keys($postsByID)) . ")")
    ->fetchAll(PDO::FETCH_CLASS, Category::class);

foreach ($categories as $category) {
    $postsByID[$category->getPostID()]->addCategory($category);
 $link = $router->url('Accueil');
}
 foreach ($categories as $category) {
        $postsByID[$category->getPostID()]->addCategory($category);
       }

$page=$_GET['page']?? 1;
if(!filter_var($page, FILTER_VALIDATE_INT)){
    throw new Exception("Le numéro de page n'est pas valide");
}
$currentPage=(int)($_GET['page']?? 1) ?:1 ;
if($currentPage < 1){
    throw new Exception('Page introuvable', 404);
}
if($page==='1'){
    header('Location: '.$router->url('Accueil'));
    http_response_code(301);
    exit();
}
$count =(int)$pdo->query('SELECT COUNT(id) FROM article')->fetch(PDO::FETCH_NUM)[0];
$perPage=12;
$pages=ceil($count / $perPage);
if($currentPage > $pages){
    throw new Exception('Page introuvable', 404);
}
$offset=($currentPage - 1) * $perPage;
$query=$pdo->prepare("SELECT * FROM article ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$query->bindValue(':limit', $perPage, PDO::PARAM_INT);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$posts=$query->fetchAll(PDO::FETCH_CLASS,Post::class);
?>
<h1>Mes articles de blog</h1>
<div class="row">
    <?php foreach ($posts as $post): ?>
    <div class="col-md-4">
        <?php require 'card.php' ?>
    </div>
    <?php endforeach ?>
</div>




<!-- 
<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1): ?>
        <?php
            $prevLink = $router->url('Accueil');             
            if ($currentPage > 2) {
                $prevLink .= '?page=' . ($currentPage - 1);
            }
        ?>
        <a href="<?= htmlspecialchars($prevLink, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary">
            &laquo; Page précédente
        </a>
    <?php endif; ?>

    <?php if ($currentPage < $pages): ?>
        <?php
      
            $nextLink = $router->url('Accueil') . '?page=' . ($currentPage + 1);
        ?>
        <a href="<?= htmlspecialchars($nextLink, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary ml-auto">
            Page suivante &raquo;
        </a>
    <?php endif; ?> -->
    



    <div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link); ?>
        <?= $pagination->nextLink($link); ?>

    </div>
</div>
