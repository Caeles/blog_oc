<?php

use App\Connection;
use App\Table\UserTable;
use App\Auth;

Auth::check();

$id = (int)$params['id'];
$pdo = Connection::getPDO();
$userTable = new UserTable($pdo);

// Vu00e9rifier que l'utilisateur existe
try {
    $user = $userTable->find($id);
} catch (Exception $e) {
    header('Location: ' . $router->url('admin_users') . '?error=1');
    exit();
}

// Empu00eacher la suppression de l'utilisateur connectu00e9
if (isset($_SESSION['auth']) && $_SESSION['auth'] === $id) {
    header('Location: ' . $router->url('admin_users') . '?self_delete_error=1');
    exit();
}

// Supprimer l'utilisateur
$pdo->prepare("DELETE FROM user WHERE id = ?")->execute([$id]);

header('Location: ' . $router->url('admin_users') . '?deleted=1');
exit();
