
<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Céline PIPER' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="<?= $router->url('home') ?>" class="navbar-brand">Panel Administrateur</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="<?= $router->url('admin_posts') ?>" class="nav-link">Articles</a>
            </li>
            <li class="nav-item">
                <a href="<?= $router->url('admin_categories') ?>" class="nav-link">Categories</a>
            </li>
            <li class="nav-item">
                <a href="<?= $router->url('admin_comments') ?>" class="nav-link">Commentaires</a>
            </li>
            <li class="nav-item">
                <a href="<?= $router->url('admin_users') ?>" class="nav-link">Utilisateurs</a>
            </li>
            <li class="nav_item">
                <form action="<?= $router->url('logout') ?>" method="post" style="display:inline">
                    <button type="submit" class="nav-link" style="background:transparent; border:none;">Se deconnecter</button>
                </form>
            </li>
        </ul>
    </nav>
    
    <div class="container mt-4">
        <?= $content ?>
    </div>

    <footer class="bg-light py-4 footer mt-auto text-center"> 

    <p class="small">&copy; PIPER . Tous droits réservés</p>

    </footer>
</body>
</html>