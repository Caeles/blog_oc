<?php

use App\Connection;
use App\Table\UserTable;
use App\Model\User;
use App\HTML\Form;
use App\Auth;

Auth::check();
$router->layout = 'admin/layouts/default';
$title = "Mettre à jour un utilisateur";
$pdo = Connection::getPDO();

$userTable = new UserTable($pdo);
$user = $userTable->find($params['id']);

$roleQuery = $pdo->query("SELECT id, value FROM role ORDER BY value");
$roles = $roleQuery->fetchAll(PDO::FETCH_KEY_PAIR);

$statusQuery = $pdo->query("SELECT id, value FROM status ORDER BY value");
$statuses = $statusQuery->fetchAll(PDO::FETCH_KEY_PAIR);

$errors = [];
$success = false;

if (!empty($_POST)) {
    $user->setNom($_POST['nom'] ?? '');
    $user->setPrenom($_POST['prenom'] ?? '');
    $user->setEmail($_POST['email'] ?? '');
    $user->setRoleId($_POST['role_id'] ?? 0);
    $user->setStatusId($_POST['status_id'] ?? 0);
    
    if (!empty($_POST['password'])) {
        // Hasher le mot de passe
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
    }
    
    if ($userTable->exists('email', $user->getEmail(), $user->getId())) {
        $errors['email'] = "Cet email est du00e9ju00e0 utilisu00e9 par un autre utilisateur";
    }
    
    if (empty($errors)) {
        if (!empty($_POST['password'])) {
            $pdo->prepare("UPDATE user SET nom = ?, prenom = ?, email = ?, mot_de_passe = ?, role_id = ?, status_id = ? WHERE id = ?")
                ->execute([
                    $user->getNom(),
                    $user->getPrenom(),
                    $user->getEmail(),
                    $user->getPassword(),
                    $user->getRoleId(),
                    $user->getStatusId(),
                    $user->getId()
                ]);
        } else {
            $pdo->prepare("UPDATE user SET nom = ?, prenom = ?, email = ?, role_id = ?, status_id = ? WHERE id = ?")
                ->execute([
                    $user->getNom(),
                    $user->getPrenom(),
                    $user->getEmail(),
                    $user->getRoleId(),
                    $user->getStatusId(),
                    $user->getId()
                ]);
        }
        
        $success = true;
    }
}

$form = new Form($user, $errors);

?>

<h1>Mettre à jour l'utilisateur</h1>

<?php if ($success): ?>
    <div class="alert alert-success">
        L'utilisateur a bien été modifié.
    </div>
<?php endif; ?>

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
        <?= $form->input('password', 'Mot de passe (laisser vide pour ne pas modifier)', 'password') ?>
    </div>
    
    <div class="mb-4">
        <?= $form->select('role_id', 'Rôle', $roles) ?>
    </div>
    
    <div class="mb-4">
        <?= $form->select('status_id', 'Statut', $statuses) ?>
    </div>
    
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>

<p class="mt-4">
    <a href="<?= $router->url('admin_users') ?>" class="btn btn-secondary">Retour à la liste d'utilisateurs</a>
</p>
