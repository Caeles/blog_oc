
<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Mon site' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body class="d-flex flex-column h-100" style="padding-top: 70px;">
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="<?= $router->url('home') ?>" class="navbar-brand">Home</a>
    </nav> -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= $router->url('home') ?>">CELINE PIPER</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link active" href="<?= $router->url('home') ?>">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $router->url('home') ?>#about">Réalisations</a></li>
                    <li class="nav-item"><a class="nav-link" href="/blog">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $router->url('home') ?>#work">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Se Connecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <?= $content ?>
    </div>
    
    <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
            
        </div>
    </footer>
</body>
</html>