<div class="card-body">
        <h3 class="card-title"><?= htmlentities($post->getName()) ?></h3>
        <h5><?= htmlentities($post->getChapo()) ?></h5>
        <p class="card-text"><?= $post->getExcerpt() ?></p>
        <p class="text-muted"><?php
            $dateTime = $post->getCreatedAt();
            $formatter = new IntlDateFormatter(
                'fr_FR',
                IntlDateFormatter::LONG,
                IntlDateFormatter::SHORT,
                null,
                null,
                'd MMMM y HH\'h\'mm'
            );
            echo $formatter->format($dateTime);
            ?></p>
        <a href="<?= $router ->url('post', ['id' => $post->getID()]) ?>" class="btn btn-primary">Lire la suite</a>
    </div>