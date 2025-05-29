<?php
use App\Connection;
use App\Table\CommentTable;
use App\Auth;


Auth::check();

$id = (int)$params['id'];
$pdo = Connection::getPDO();

$commentTable = new CommentTable($pdo);
$result = $commentTable->updateStatus($id, 'approved');

header('Location: ' . $router->url('admin_comments') . '?approved=1');
exit();
