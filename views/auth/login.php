<?php

use App\Connection;
use App\Model\User;
use App\HTML\Form;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;

$user = new User();
$errors = [];
if(!empty($_POST)){
    if(isset($_POST['email'])) {
        $user->setEmail($_POST['email']);
    }
    
    $errors['password'] = 'Email ou mot de passe incorrect';
    
    if(!empty($_POST['email']) && !empty($_POST['password'])){
        $table = new UserTable(Connection::getPDO());
        try{
            $u = $table->findByUser($_POST['email']);
            if (password_verify($_POST['password'], $u->getPassword()) ===  true){
                session_start();
                $_SESSION['auth'] = $u->getID();
                header('Location: '. $router->url('admin_posts'));
                exit();
            }   

        }catch(Exception $e){
            $errors['password']="Email ou mot de passe incorrect";
        }
    }
}

$form = new Form($user, $errors);

?>

<h1>Se connecter</h1>

<?php if(isset($_GET['forbidden'])) { ?>
<div class="alert alert-danger">
    Vous ne pouvez pas accèder à cette page
</div>
<?php } ?>

<form action="<?= $router->url('login') ?>" method="POST">
    <?= $form->input('email', 'Email') ?>
    <?= $form->input('password', 'Mot de passe')?>
    <div class="mb-3"></div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>