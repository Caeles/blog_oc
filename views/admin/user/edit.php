<?php

use App\Connection;
use App\Table\UserTable;
use App\Model\User;
use App\HTML\Form;
use App\Auth;

Auth::check();
$router->layout = 'admin/layouts/default';
$title = "u00c9diter un utilisateur";
$pdo = Connection::getPDO();

// Ru00e9cupu00e9rer l'utilisateur
$userTable = new UserTable($pdo);
$user = $userTable->find($params['id']);

// Ru00e9cupu00e9rer les ru00f4les disponibles
$roleQuery = $pdo->query("SELECT id, value FROM role ORDER BY value");
$roles = $roleQuery->fetchAll(PDO::FETCH_KEY_PAIR);

// Ru00e9cupu00e9rer les statuts disponibles
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
    
    // Vu00e9rifier si un nouveau mot de passe a u00e9tu00e9 saisi
    if (!empty($_POST['password'])) {
        // Hasher le mot de passe
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
    }
    
    // Vu00e9rifier si l'email est du00e9ju00e0 utilisu00e9 par un autre utilisateur
    if ($userTable->exists('email', $user->getEmail(), $user->getId())) {
        $errors['email'] = "Cet email est du00e9ju00e0 utilisu00e9 par un autre utilisateur";
    }
    
    // Si pas d'erreurs, mettre u00e0 jour l'utilisateur
    if (empty($errors)) {
        if (!empty($_POST['password'])) {
            // Mise u00e0 jour avec nouveau mot de passe
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
            // Mise u00e0 jour sans changer le mot de passe
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
        L'utilisateur a bien u00e9tu00e9 modifiu00e9.
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
