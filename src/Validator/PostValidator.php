<?php
namespace App\Validators;

use App\Table\PostTable;

class   PostValidator extends AbstractValidator{

    public function __construct(array $data, PostTable $table, ?int $postID = null, ?array $categories = null){

        parent::__construct($data);
        $this->validator->rule('required', ['title']);
        $this->validator->rule('lengthBetween', ['title'], 3, 200);
        $this->validator->rule('subset', 'categories_ids', array_keys($categories));
        $this->validator->rule(function ($field, $value) use ($table, $postID) {
            return !$table->exists($field, $value, $postID);
        }, ['title'], 'Cette valeur est déja utilisée');
    }
    
    
}