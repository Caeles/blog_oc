<?php
use App\Connection;
use App\Model\Category;
use App\Helpers\URL;
use App\Model\Post;
use App\PaginatedQuery;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'] ;
$name = $params['name'] ;

$pdo = Connection::getPDO();
$category =  new CategoryTable($pdo)->find($id);



if ($category->getName() !== $name) {
    $url = $router->url('category', [
        'id' => $category->getID(),
        'name' => $category->getName()
    ]);
    http_response_code(301);
    header('Location:' . $url);
    exit();
}


if($category->getSlug()!==$slug){
 $url=$router->url('category',['id'=>$id,'slug'=>$category->getSlug()]);

 http_response_code(301);
 header('Location:'.$url);
exit();     
}
?>


<h1><?= e($category->getName()) ?></h1>


<?php
$paginatedQuery = new PaginatedQuery(
    "SELECT p.* 
FROM post p
JOIN post_category pc ON pc.post_id = p.id
WHERE pc.category_id = {$category->getID()}
ORDER BY created_at DESC ",
    "SELECT COUNT(category_id) FROM post_category WHERE category_id {$category->getID()}",
    Post::class,
    
);

$title = "Catégorie {$category->getName()}";
[$posts,$paginatedQuery]=(new PostTable($pdo))->findPaginatedForCategory($category->getID());


//en trop
// $currentPage=URL::getPositiveInt('page',1);

$count=(int) $pdo->query('SELECT COUNT(category_id) FROM post_category WHERE category_id = ' . $category->getID())->fetch(PDO::FETCH_NUM)[0];
$perpage=12;
$pages=ceil($count/$perpage);
if($currentPage > $pages){
    throw new Exception("Cette page n'existe pas");
}
$offset=$perpage * ($currentPage - 1);
// $query = $pdo->query("
// SELECT p.* 
// FROM post p
// JOIN post_category pc ON pc.post_id = p.id
// WHERE pc.category_id = {$category->getID()}
// ORDER BY created_at DESC 
// LIMIT $perpage OFFSET $offset
// ");

/** @var Post []*/
// $posts = $paginatedQuery->getItems();


//findetrop

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

