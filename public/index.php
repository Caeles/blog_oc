<?php
require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new App\Router(dirname(__DIR__) . '/views');
$router 
        -> get('/', 'home/home', 'home')
        -> get('/articles/blog[*:page]', 'post/index', 'posts')
        -> get('/blog', 'post/index','Accueil')
        ->get('/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
        -> get('/blog/[i:id]', 'post/show','post')
        -> post('/blog/comment/[i:id]', 'comment/submit', 'post_comment')
        -> get('/comment/init', 'comment/init', 'comment_init')
        //Auth
        
        ->match('/login', 'auth/login', 'login')
        ->post('/logout', 'auth/logout','logout')
        //Admin
        -> get('/admin', 'admin/post/index','admin_posts')
        -> match('/admin/post/[i:id]', 'admin/post/edit','admin_post')
        //Gestion des articles
        ->match('/admin/post/new', 'admin/post/new', 'admin_post_new')        
        -> post('/admin/post/[i:id]/delete', 'admin/post/delete','admin_post_delete')
         //Gestion des catégories
        ->get('/admin/categories', 'admin/category/index', 'admin_categories')
        ->match('/admin/category/[i:id]', 'admin/category/edit', 'admin_category')
        ->post('/admin/category/[i:id]/delete', 'admin/category/delete', 'admin_category_delete')
        ->match('/admin/category/new', 'admin/category/new', 'admin_category_new')
        //Gestion des commentaires
        ->get('/admin/comments', 'admin/comment/index', 'admin_comments')
        ->post('/admin/comment/[i:id]/approve', 'admin/comment/approve', 'admin_comment_approve')
        ->post('/admin/comment/[i:id]/reject', 'admin/comment/reject', 'admin_comment_reject')
        //Gestion des utilisateurs
        ->get('/admin/users', 'admin/user/index', 'admin_users')
        ->match('/admin/user/new', 'admin/user/new', 'admin_user_new')
        ->match('/admin/user/[i:id]', 'admin/user/edit', 'admin_user_edit')
        ->post('/admin/user/[i:id]/delete', 'admin/user/delete', 'admin_user_delete')
        -> run();
function e(string $string): string
{
    return htmlspecialchars($string);
}
