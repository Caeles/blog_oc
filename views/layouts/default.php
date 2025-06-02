
<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Celine PIPER' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
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
    <div class="container mt-5 mb-5" style="margin-bottom: 30px">
        <?= $content ?>
    </div>
    
    <!-- <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
            
        </div>
    </footer> -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="h4">Céline PIPER</p>
        <div class="mb-2">
            <a href="www.facebook.com" class="text-white mx-2"><i class="bx bxl-facebook"></i></a>
            <a href="www.instagram.com" class="text-white mx-2"><i class="bx bxl-instagram"></i></a>
            <a href="www.twitter.com" class="text-white mx-2"><i class="bx bxl-twitter"></i></a>
            <a class="nav-link" href="/login">Se Connecter</a>
        </div>
        <p class="small">&copy; PIPER . Tous droits réservés</p>
    </footer>
</body>
</html>