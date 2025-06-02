<div class="card-body">
        <h3 class="card-title"><?= htmlentities($post->getName()) ?></h3>
        <?php if(!empty($post->getCategories())): ?>
        <div class="mb-2">
            <?php foreach ($post->getCategories() as $k => $category): ?>
                <?php if($k > 0): echo ' '; endif; ?>
                <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>"
                   class="badge bg-primary text-white text-decoration-none">
                    <?= htmlentities($category->getName()) ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <h5><?= htmlentities($post->getChapo()) ?></h5>
    
        <p class="card-text"><?= $post->getExcerpt() ?></p> 
        <!-- Fonction dans le namespace App\Helpers\Text -->
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