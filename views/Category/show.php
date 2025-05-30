<?php
use App\Connection;
use App\Model\Category;
use App\Helpers\URL;
use App\Model\Post;
use App\PaginatedQuery;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$category =  new CategoryTable($pdo)->find($id);




if ($category->getSlug() !== $slug) {
    $url = $router->url('category', [
        'id' => $category->getID(),
        'slug' => $category->getSlug()
    ]);
    http_response_code(301);
    header('Location:' . $url);
    exit();
}
?>


<?php
$paginatedQuery = new PaginatedQuery(
    "SELECT p.* 
FROM post p
JOIN post_category pc ON pc.post_id = p.id
WHERE pc.category_id = {$category->getID()}
ORDER BY created_at DESC ",
    "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$category->getID()}",
    $pdo
);

$title = "Catégorie: {$category->getName()}";

[$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($category->getID());




$link=$router->url('category', [
    'id' => $category->getID(),
    'slug' => $category->getSlug()
]);
?>

<h1><?= e($title) ?></h1>

<div class="row">
    <?php foreach ($posts as $post): ?>
    <div class="col-md-4">
        <?php require dirname(__DIR__).'/post/card.php' ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>
</div>

