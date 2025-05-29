<?php
use App\Connection;
use App\Table\CommentTable;
use App\Auth;

Auth::check();

$id = (int)$params['id'];
$pdo = Connection::getPDO();

$commentTable = new CommentTable($pdo);
$result = $commentTable->updateStatus($id, 'rejected');

header('Location: ' . $router->url('admin_comments') . '?rejected=1');
exit();
