<?php
namespace App\Table;
use App\Model\Post;
use App\Model\Category;
use App\Table\Exception\NotFoundException;
use \PDO;

final class CategoryTable extends Table{

    protected $table='category';
    protected $class=Category::class;

    /**
     * @param App\Model\Post[] $posts
     */
    public function hydratePosts(array $posts):void
    {
        $postsByID=[];
        foreach($posts as $post){
            $post->setCategories([]);
            $postsByID[$post->getID()]=$post;
        }
        $categories=$this->pdo
            ->query("SELECT c.*, pc.article_id
            FROM article_category pc
            JOIN category c ON c.id = pc.category_id
            WHERE pc.article_id IN (" . implode(',', array_keys($postsByID)) . ")")
    ->fetchAll(PDO::FETCH_CLASS, $this->class);
            
        foreach($categories as $category){
            $postsByID[$category->getPostID()]->addCategory($category);
        }
    }

    public function list():array
    {
        $categories=$this->pdo->query("SELECT * FROM {$this->table} ORDER BY name ASC",PDO::FETCH_CLASS,$this->class)->fetchAll();
        $results=[];
        foreach($categories as $category){
            $results[$category->getID()]=$category->getName();
        }
        return $results;
    }

    // public function find (int $id): Category
    // {
    //     $query=$this->pdo->prepare("SELECT * FROM category WHERE id = id");
    //     $query->execute(['id' =>$id]);
    //     $query->setFetchMode(PDO::FETCH_CLASS,Category::class);
    //     $result=$query->fetch();
    //     if($result===false){
    //         throw new NotFoundException('category',$id);
    //     }
    //     return $result;
    // }

}