<?php

use App\Connection;

require __DIR__ . '/../vendor/autoload.php';

$pdo = Connection::getPDO();

$roleCheck = $pdo->query("SELECT id FROM role WHERE value = 'admin' LIMIT 1")->fetch();
if (!$roleCheck) {
    $pdo->exec("INSERT INTO role (value) VALUES ('admin')");
    echo "Created admin role\n";
}

$statusCheck = $pdo->query("SELECT id FROM status WHERE value = 'active' LIMIT 1")->fetch();
if (!$statusCheck) {
    $pdo->exec("INSERT INTO status (value) VALUES ('active')");
    echo "Created active status\n";
}


$roleId = $pdo->query("SELECT id FROM role WHERE value = 'admin' LIMIT 1")->fetch(PDO::FETCH_COLUMN);
$statusId = $pdo->query("SELECT id FROM status WHERE value = 'active' LIMIT 1")->fetch(PDO::FETCH_COLUMN);

$password = password_hash('admin', PASSWORD_BCRYPT);

$pdo->exec("DELETE FROM user WHERE email = 'admin@example.com'");

$stmt = $pdo->prepare("INSERT INTO user (nom, prenom, email, mot_de_passe, role_id, status_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute(['Admin', 'User', 'admin@example.com', $password, $roleId, $statusId]);

echo "Admin user created successfully.\n";
