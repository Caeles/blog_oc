<?php


$title = 'Page non trouvée';

?>

<div class="container text-center py-5">
    <h1 class="display-1">404</h1>
    <h2 class="mb-4">Page non trouvée</h2>
    <p class="lead mb-5">La page que vous recherchez n'existe pas ou a été déplacée.</p>
    <a href="<?= $router->url('home') ?>" class="btn btn-primary">Retour à l'accueil</a>
</div>
