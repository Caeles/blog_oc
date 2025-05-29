<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= isset($title) ? e($title) : 'Mon site' ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header avec Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">CELINE PIPER</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#home">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Réalisations</a></li>
                    <li class="nav-item"><a class="nav-link" href="/blog">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#work">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Se Connecter</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Home Section -->
    <section id="home" class="container py-5">
        <div class="row align-items-center justify-content-between">
            <div class="col-md-6">
                <h1 class="display-4"> <span class="text-primary">Celine PIPER</span><br>Une développeuse à votre service!</h1>
                <a href="#contact" class="btn btn-primary">Me Contacter </a>
            </div>
            <div class="col-md-6 text-center">
                <img src="/assets/img1.jpeg" class="img-fluid rounded" alt="ProfileImage">
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="container py-5">
        <h2 class="section-title">A propos de moi</h2>
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="assets/profile_.jpg" class="img-fluid rounded" alt="About">
            </div>
            <div class="col-md-6">
                <p>                
Ma passion pour la résolution de problèmes me pousse à imaginer des solutions élégantes et évolutives, toujours centrées sur l’expérience utilisateur.
</br></br>Curieuse et en veille permanente, j’explore les technologies émergentes pour offrir des produits à la pointe du progrès.
</p>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="container py-5">
        <h2 class="section-title text-center mb-4">Compétences</h2>
        <div class="row justify-content-center">
            <div class="col-md-6 mx-auto">
                <div class="mb-3">
                    <h5>HTML5 <span class="float-end">95%</span></h5>
                    <div class="progress">
                        <div class="progress-bar" style="width:95%;"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <h5>CSS3 <span class="float-end">85%</span></h5>
                    <div class="progress">
                        <div class="progress-bar" style="width:85%;"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <h5>JavaScript <span class="float-end">65%</span></h5>
                    <div class="progress">
                        <div class="progress-bar" style="width:65%;"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <h5>PHP/SQL <span class="float-end">85%</span></h5>
                    <div class="progress">
                        <div class="progress-bar" style="width:85%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Work Section -->
    <section id="work" class="container py-5">
        <h2 class="section-title">Work</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <img src="assets/portfolio1.jpg" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-4 mb-4">
                <img src="assets/portfolio2.jpg" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-4 mb-4">
                <img src="assets/portfolio3.jpg" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
            <a href="/blog/public/assets/celine_piper_cv_.pdf" class="btn btn-primary" download="celine_piper_cv.pdf">Voir mon CV</a>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="container py-5">
        <h2 class="section-title">Contact</h2>
        <form>
            <input type="text" class="form-control mb-3" placeholder="Nom">
            <input type="email" class="form-control mb-3" placeholder="E-mail">
            <textarea class="form-control mb-3" placeholder="Votre Message" rows="5"></textarea>
            <button class="btn btn-primary" type="submit">Envoyer</button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="h4">Céline PIPER</p>
        <div class="mb-2">
            <a href="www.facebook.com" class="text-white mx-2"><i class="bx bxl-facebook"></i></a>
            <a href="www.instagram.com" class="text-white mx-2"><i class="bx bxl-instagram"></i></a>
            <a href="www.twitter.com" class="text-white mx-2"><i class="bx bxl-twitter"></i></a>
            <a class="nav-link" href="/login">Se Connecter</a>
        </div>
        <p class="small">&copy; PIPER . Tous droits réservés</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
