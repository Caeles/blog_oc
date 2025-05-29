<?php
namespace App\Model;

class Category
{
    private $id;
    private $slug;
    private $name;
    private $description;
    private $created_at;        
    private $post;
    private $article_id;

    public function getName():?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    public function getID(): ?int
    {
        return $this->id;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }   
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }
    public function getPostID(): ?int
    {
        return $this->article_id;
    }
    public function setPost(Post $post)
    {
        $this->post = $post;
       
    }
}
