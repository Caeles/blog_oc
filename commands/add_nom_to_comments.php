<?php

use App\Connection;

require __DIR__ . '/../vendor/autoload.php';

$pdo = Connection::getPDO();


$checkColumn = $pdo->query("SHOW COLUMNS FROM comment LIKE 'nom'");
$columnExists = $checkColumn->rowCount() > 0;

if (!$columnExists) {
    echo "Ajout de la colonne 'nom' de la table 'comment'...\n";
    $pdo->exec("ALTER TABLE comment ADD COLUMN nom VARCHAR(100) DEFAULT 'Anonyme' AFTER user_id");
    echo "Colonne 'nom' ajouté avec succès!\n";
} else {
    echo "La colonne 'nom' existe déja dans la table 'comment'.\n";
}

echo "\nOpération terminée.\n";
