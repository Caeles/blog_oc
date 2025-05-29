<?php
use App\Connection;
use App\Table\CommentTable;
use App\Model\Comment;

$articleId = (int)$params['id'];


if (!empty($_POST['contenu'])) {

    $pdo = Connection::getPDO();
    $commentTable = new CommentTable($pdo);

    $commentTable->initCommentStatus();
    

    $username = htmlspecialchars($_POST['username'] ?? 'Anonyme');
    $contenu = htmlspecialchars($_POST['contenu']);

    $userId = 0; 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    

    if (isset($_SESSION['auth'])) {
        $userId = (int)$_SESSION['auth'];
    }
    

    $result = $commentTable->createComment($articleId, $contenu, $userId);
    

    if ($result) {
        header('Location: ' . $router->url('post', ['id' => $articleId]) . '?comment_added=1');
        exit();
    } else {

        header('Location: ' . $router->url('post', ['id' => $articleId]) . '?comment_error=1');
        exit();
    }
} else {

    header('Location: ' . $router->url('post', ['id' => $articleId]));
    exit();
}
