<?php

use App\Connection;

require __DIR__ . '/../vendor/autoload.php';

$pdo = Connection::getPDO();


$checkColumn = $pdo->query("SHOW COLUMNS FROM comment LIKE 'nom'");
$columnExists = $checkColumn->rowCount() > 0;

if (!$columnExists) {
    echo "Ajout de la colonne 'nom' u00e0 la table 'comment'...\n";
    $pdo->exec("ALTER TABLE comment ADD COLUMN nom VARCHAR(100) DEFAULT 'Anonyme' AFTER user_id");
    echo "Colonne 'nom' ajoutu00e9e avec succu00e8s!\n";
} else {
    echo "La colonne 'nom' existe du00e9ju00e0 dans la table 'comment'.\n";
}

echo "\nOpu00e9ration terminu00e9e.\n";
