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
    private $article_title;
    private $nom; 

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
        // Appliquer seulement nl2br pour les sauts de ligne, sans htmlentities
        // pour u00e9viter le double encodage des caractu00e8res spu00e9ciaux
        return nl2br($this->contenu);
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

    public function getArticleTitle(): ?string
    {
        return $this->article_title;
    }

    public function setArticleTitle(string $article_title): self
    {
        $this->article_title = $article_title;
        return $this;
    }

    /**
     * Get the value of nom
     *
     * @return  string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @param  string  $nom
     *
     * @return  self
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
}
