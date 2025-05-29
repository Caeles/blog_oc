<?php
use App\Connection;
use App\Table\CommentTable;


$pdo = Connection::getPDO();


$checkTable = $pdo->query("SHOW TABLES LIKE 'comment_status'");
if ($checkTable->rowCount() === 0) {
    echo "<p>Cru00e9ation de la table comment_status...</p>";
    $pdo->exec("CREATE TABLE IF NOT EXISTS comment_status (id INT AUTO_INCREMENT PRIMARY KEY, value VARCHAR(50) NOT NULL UNIQUE)");
}


$statuses = ['pending', 'approved', 'rejected'];
foreach ($statuses as $status) {
    $checkStatus = $pdo->prepare("SELECT COUNT(*) FROM comment_status WHERE value = ?");
    $checkStatus->execute([$status]);
    if ((int)$checkStatus->fetchColumn() === 0) {
        $insertStatus = $pdo->prepare("INSERT INTO comment_status (value) VALUES (?)");
        $insertStatus->execute([$status]);
        echo "<p>Statut '{$status}' ajoutu00e9.</p>";
    }
}


$approvedQuery = $pdo->prepare("SELECT id FROM comment_status WHERE value = 'approved'");
$approvedQuery->execute();
$approvedId = $approvedQuery->fetchColumn();

if ($approvedId) {

    $updateQuery = $pdo->prepare("UPDATE comment SET status_id = ? WHERE status_id IS NULL OR status_id = 0");
    $updateQuery->execute([$approvedId]);
    $updated = $updateQuery->rowCount();
    
    echo "<p>{$updated} commentaires ont u00e9tu00e9 approuvu00e9s.</p>";
    

    $countQuery = $pdo->query("SELECT cs.value, COUNT(c.id) as count FROM comment c JOIN comment_status cs ON c.status_id = cs.id GROUP BY cs.value");
    echo "<p>Statistiques des commentaires :</p><ul>";
    while ($row = $countQuery->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>{$row['value']}: {$row['count']}</li>";
    }
    echo "</ul>";
    
    echo "<p><a href='/blog'>Retourner au blog</a></p>";
} else {
    echo "<p>Erreur: Impossible de trouver le statut 'approved'.</p>";
}
