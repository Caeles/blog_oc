<?php

use App\Connection;
use App\Model\Post;
use App\Table\PostTable;
use App\Table\UserTable;
use App\Validator;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\ObjectHelper;
use App\Auth;
use App\Table\CategoryTable;

Auth::check();

$errors = [];
$post = new Post();
$pdo = Connection::getPDO();
$categorytable = new CategoryTable($pdo);
$userTable = new UserTable($pdo);
$categories = $categorytable->list();
$authors = $userTable->list();
date_default_timezone_set('Europe/Paris');
$post->setCreatedAt(date('Y-m-d H:i:s'));

if(!empty($_POST)){

    $postTable = new PostTable($pdo);

    Validator::lang('fr');
    $v = new PostValidator($_POST, $postTable, $post->getID(), $categories);
    ObjectHelper::hydrate($post, $_POST, ['title', 'chapo', 'description', 'author_id', 'created_at']);
    if($v->validate()){
        $pdo->beginTransaction();
        $postTable->createPost($post);
        $postTable->attachCategories($post->getId(), $_POST['categories_ids']);
        $pdo->commit();
        header('Location: ' . $router->url('admin_post', ['id' => $post->getId()]) . '?created=1');
        exit();
    }else{ 
        $errors  = $v->errors();
    }
    
   
}
$form = new Form($post, $errors)

?>

<?php if (!empty($errors)) : ?>
<div class="alert alert-danger">
    L'article n'a pas pu être enregistré, merci de corriger les erreurs
</div>
<?php endif ?>  


<h1>Créer un article</h1>

<?php require('_form.php') ?>