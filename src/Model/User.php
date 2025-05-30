<?php

namespace App\Model;

class User
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     * Database column alias for $password
     */
    private $mot_de_passe;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @var int
     */
    private $role_id;

    /**
     * @var int
     */
    private $status_id;


    /**
     * Get the value of username
     *
     * @return  string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @param  string  $username
     *
     * @return  self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */
    public function getPassword(): ?string
    {
        return $this->mot_de_passe;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        $this->mot_de_passe = $password; 
        return $this;
    }

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nom
     *
     * @return  string
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

    /**
     * Get the value of email
     *
     * @return  string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of prenom
     *
     * @return  string
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @param  string  $prenom
     *
     * @return  self
     */
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of mot_de_passe (alias for password)
     *
     * @return  string
     */
    public function getMotDePasse(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of mot_de_passe (alias for password)
     *
     * @param  string  $mot_de_passe
     *
     * @return  self
     */
    public function setMotDePasse(string $mot_de_passe): self
    {
        $this->password = $mot_de_passe;
        $this->mot_de_passe = $mot_de_passe;

        return $this;
    }

    /**
     * Get the value of telephone
     *
     * @return  string
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @param  string  $telephone
     *
     * @return  self
     */
    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of role_id
     *
     * @return  int
     */
    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    /**
     * Set the value of role_id
     *
     * @param  int  $role_id
     *
     * @return  self
     */
    public function setRoleId(int $role_id): self
    {
        $this->role_id = $role_id;

        return $this;
    }

    /**
     * Get the value of status_id
     *
     * @return  int
     */
    public function getStatusId(): ?int
    {
        return $this->status_id;
    }

    /**
     * Set the value of status_id
     *
     * @param  int  $status_id
     *
     * @return  self
     */
    public function setStatusId(int $status_id): self
    {
        $this->status_id = $status_id;

        return $this;
    }
}