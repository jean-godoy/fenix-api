<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

 // public function __construct()
    // {
    //     /**
    //      * transaction  with doctrine
    //      * 
    //      * 
    //      * commit and rollback
    //      * 
    //      * 
    //      *  @ ORM\Column(type="char", length=36)
    //      */

    //     $this->created_at = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
    //     $this->updated_at = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
    // }

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $user_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $user_email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $user_pass;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $user_code;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted_at;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(string $user_email): self
    {
        $this->user_email = $user_email;

        return $this;
    }

    public function getUserPass(): ?string
    {
        return $this->user_pass;
    }

    public function setUserPass(string $user_pass): self
    {
        $this->user_pass = $user_pass;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of roles
     */ 
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */ 
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUserCode(): ?string
    {
        return $this->user_code;
    }

    public function setUserCode(string $user_code): self
    {
        $this->user_code = $user_code;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    
}
