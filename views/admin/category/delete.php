<?php

use App\Auth;
use App\Connection;
use App\Model\Category;
use App\Table\CategoryTable;

Auth::check();
$pdo = Connection::getPDO();
$table = new CategoryTable($pdo);
//$table->delete($params['id']);
header('Location: ' . $router->url('admin_categories') . '?delete=1');
?>
<h1>Suppression de <?= $params['id'] ?></h1>