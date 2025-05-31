<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Table\UserTable;
use App\Validators;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\ObjectHelper;
use App\Auth;
use App\Validator;

Auth::check();

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$categorytable = new CategoryTable($pdo);
$userTable = new UserTable($pdo);
$categories = $categorytable->list();
$authors = $userTable->list();
$post = $postTable->find($params['id']);
$categorytable->hydratePosts([$post]);
$success = false;

$errors = [];

if(!empty($_POST)){
    Validator::lang('fr');
    $v = new PostValidator($_POST, $postTable, $post->getID(), $categories);
    ObjectHelper::hydrate($post, $_POST, ['title', 'chapo', 'description', 'created_at', 'author_id']);
    if($v->validate()){
        $pdo->beginTransaction();
        $postTable->updatePost($post);
        $postTable->attachCategories($post->getId(), $_POST['categories_ids']);
        $pdo->commit();
        $categorytable->hydratePosts([$post]);
        $success = true;
    }else{
        $errors  = $v->errors();
    }
    
   
}
$form = new Form($post, $errors)

?>

<?php if ($success) : ?>
<div class="alert alert-success">
    L'article a bien été modifié
</div>
<?php endif ?>

<?php if (isset($_GET['created'])) : ?>
<div class="alert alert-success">
    L'article a bien été créé
</div>
<?php endif ?>

<?php if (!empty($errors)) : ?>
<div class="alert alert-danger">
    L'article n'a pas pu être modifié, merci de corriger les erreurs
</div>
<?php endif ?>


<h1>Editer l'article<br><?= e($post->getName()) ?></h1>

<?php require('_form.php') ?>