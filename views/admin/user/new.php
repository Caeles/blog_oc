<?php

use App\Connection;
use App\Table\UserTable;
use App\Model\User;
use App\HTML\Form;
use App\Auth;

Auth::check();
$router->layout = 'admin/layouts/default';
$title = "Ajouter un utilisateur";
$pdo = Connection::getPDO();

// Récupérer les rôles disponibles
$roleQuery = $pdo->query("SELECT id, value FROM role ORDER BY value");
$roles = $roleQuery->fetchAll(PDO::FETCH_KEY_PAIR);

// Récupérer les statuts disponibles
$statusQuery = $pdo->query("SELECT id, value FROM status ORDER BY value");
$statuses = $statusQuery->fetchAll(PDO::FETCH_KEY_PAIR);

$user = new User();
$errors = [];

if (!empty($_POST)) {
    $user->setNom($_POST['nom'] ?? '');
    $user->setPrenom($_POST['prenom'] ?? '');
    $user->setEmail($_POST['email'] ?? '');
    $user->setRoleId($_POST['role_id'] ?? 0);
    $user->setStatusId($_POST['status_id'] ?? 0);
    
    // Vérifier si un mot de passe a été saisi
    if (!empty($_POST['password'])) {
        // Hasher le mot de passe
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
    } else {
        $errors['password'] = "Le mot de passe est obligatoire";
    }
    
    // Vérifier si l'email est déjà utilisé
    $userTable = new UserTable($pdo);
    if ($userTable->exists('email', $user->getEmail())) {
        $errors['email'] = "Cet email est déjà utilisé";
    }
    
    // Si pas d'erreurs, ajouter l'utilisateur
    if (empty($errors)) {
        $pdo->prepare("INSERT INTO user (nom, prenom, email, mot_de_passe, role_id, status_id) VALUES (?, ?, ?, ?, ?, ?)")
            ->execute([
                $user->getNom(),
                $user->getPrenom(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getRoleId(),
                $user->getStatusId()
            ]);
        
        header('Location: ' . $router->url('admin_users') . '?created=1');
        exit();
    }
}

$form = new Form($user, $errors);

?>

<h1>Ajouter un utilisateur</h1>

<form action="" method="POST">
    <div class="mb-4">
        <?= $form->input('nom', 'Nom') ?>
    </div>
    
    <div class="mb-4">
        <?= $form->input('prenom', 'Prénom') ?>
    </div>
    
    <div class="mb-4">
        <?= $form->input('email', 'Email') ?>
    </div>
    
    <div class="mb-4">
        <?= $form->input('password', 'Mot de passe', 'password') ?>
    </div>
    
    <div class="mb-4">
        <?= $form->select('role_id', 'Rôle', $roles) ?>
    </div>
    
    <div class="mb-4">
        <?= $form->select('status_id', 'Statut', $statuses) ?>
    </div>
    
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

<p class="mt-4">
    <a href="<?= $router->url('admin_users') ?>" class="btn btn-secondary">Retour à la liste d'utilisateurs</a>
</p>
