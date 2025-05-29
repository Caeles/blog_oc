<?php

use App\Connection;
use App\Table\UserTable;
use App\Model\User;
use App\Auth;

Auth::check();
$router->layout = 'admin/layouts/default';
$title = "Gestion des utilisateurs";
$pdo = Connection::getPDO();
$userTable = new UserTable($pdo);
$users = $userTable->all();

?>

<h1>Gestion des utilisateurs</h1>

<?php if (isset($_GET['created']) && $_GET['created'] == 1): ?>
    <div class="alert alert-success">
        L'utilisateur a bien été créé.
    </div>
<?php endif; ?>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
    <div class="alert alert-success">
        L'utilisateur a bien été supprimé.
    </div>
<?php endif; ?>

<table class="table">
    <thead>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>
            <a href="<?= $router->url('admin_user_new') ?>" class="btn btn-primary">Ajouter un utilisateur</a>
        </th>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
        <tr>
            <td>#<?= $user->getId() ?></td>
            <td><?= e($user->getNom()) ?></td>
            <td><?= e($user->getPrenom()) ?></td>
            <td><?= e($user->getEmail()) ?></td>
            <td>
                <?php
                $roleQuery = $pdo->prepare("SELECT value FROM role WHERE id = ?");
                $roleQuery->execute([$user->getRoleId()]);
                $role = $roleQuery->fetchColumn() ?: 'Inconnu';
                echo ucfirst($role);
                ?>
            </td>
            <td>
                <a href="<?= $router->url('admin_user_edit', ['id' => $user->getId()]) ?>" class="btn btn-sm btn-primary">Éditer</a>
                <form action="<?= $router->url('admin_user_delete', ['id' => $user->getId()]) ?>" method="POST" style="display:inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')">
                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
