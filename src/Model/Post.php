<?php
namespace App\Model;
use App\Helpers\Text;
use \DateTime;

class Post
{   
    private $id;
    private $title;       
    private $chapo;    
    private $description;
    private $created_at;
    private $updated_at;
    private $image;
    public $category;
    private $categories=[];
    public $category_id;
    private $author_id;  
    
    public function getName():?string
    {
        return $this->title;
    
    }

    public function getFormattedContent():?string
    {
        if($this->description === null) {
            return null;
        }
        return nl2br(htmlentities($this->description));
    }
    public function getTitle():?string
    {
        return $this->title;
    }
    public function getExcerpt(): ?string
    {
       if($this->description == null){
           return null;
       }
       return nl2br(htmlentities(Text::excerpt($this->description,160)));
    }
    
    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->created_at);
    }
    public function getID(): ?int
    {
        return $this->id;
    }
 
    public function getChapo(): ?string
    {
        return $this->chapo;
    }
    public function getDescription(): ?string
    {
        if($this->description === null) {
            return null;
        }
        return nl2br($this->description);
    }
    public function getImage(): ?string
    {
        return $this->image;
    }
    // public function getCategory(): ?string
    // {
    //     return $this->category;
    // }
    // public function getCategories(): ?string
    // {
    //     return $this->categories;
    // }
    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }
    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function setName(string $title): self
    {
        $this->title = $title;
        return $this;
    }
    
    public function setTitle(string $title): self
    {
        return $this->setName($title);
    }
    public function setChapo(string $chapo): self
    {
        $this->chapo = $chapo;
        return $this;
    }
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }
    // public function setUpdatedAt(string $updated_at): self
    // {
    //     $this->updated_at = $updated_at;
    //     return $this;
    // }
    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }
    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }
    public function setCategories(array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }
    public function setAuthorId(int $author_id): self
    {
        $this->author_id = $author_id;
        return $this;
    }
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }
    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }
    public function getCategories(): array
    {
        return $this->categories;
    }
    
    public function getCategoriesIds(): array
    {
        $ids = [];
        foreach($this->categories as $category) {
            $ids[] = $category->getID();
        }
        return $ids;
    }
    public function setUpdatedAt(string $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }
    // public function getCategoryId(): ?int
    // {
    //     return $this->category_id;
    // }
}