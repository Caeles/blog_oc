<?php
namespace App\Model;

use \DateTime;

class Comment
{
    private $id;
    private $article_id;
    private $user_id;
    private $status_id;
    private $contenu;
    private $created_at;
    private $username; 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleId(): ?int
    {
        return $this->article_id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getStatusId(): ?int
    {
        return $this->status_id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function getFormattedContenu(): ?string
    {
        if ($this->contenu === null) {
            return null;
        }
        return nl2br(htmlentities($this->contenu));
    }

    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->created_at);
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setArticleId(int $article_id): self
    {
        $this->article_id = $article_id;
        return $this;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function setStatusId(int $status_id): self
    {
        $this->status_id = $status_id;
        return $this;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;
        return $this;
    }

    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
}
