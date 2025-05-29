<form action="" method="POST">
    <?= $form->input('title', 'Titre') ;?>
    <?= $form->select('categories_ids', 'Catégories', $categories) ;?>
    <?= $form->textarea('description', 'Contenu') ;?>
    <?php 
    /* 
    <?= $form->input('created_at', 'Date de création') ;?>
    */
     ?>
    <button class="btn btn-primary">
        <?php if ($post->getId() !== null) : ?>
            Modifier
        <?php else : ?>
            Créer
        <?php endif ?>
    </button>
         
</form>