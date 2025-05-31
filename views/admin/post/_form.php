<form action="" method="POST">
    <?= $form->input('title', 'Titre') ;?>
    <?= $form->input('chapo', 'Chapô') ;?>
    <?= $form->select('categories_ids', 'Catégories', $categories, true) ;?>
    <?= $form->textarea('description', 'Contenu') ;?>
    <?= $form->select('author_id', 'Auteur', $authors) ;?>
    <?php 
    
     ?>
    <button class="btn btn-primary mt-3">
        <?php if ($post->getId() !== null) : ?>
            Modifier
        <?php else : ?>
            Créer
        <?php endif ?>
    </button>
         
</form>