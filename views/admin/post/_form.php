<form action="" method="POST">
    <?= $form->input('title', 'Titre') ;?>
    <?= $form->select('categories_ids', 'Catégories', $categories) ;?>
    <?= $form->textarea('description', 'Contenu') ;?>
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