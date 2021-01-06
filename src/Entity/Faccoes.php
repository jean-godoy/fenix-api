<?php

namespace App\Entity;

use App\Repository\FaccoesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FaccoesRepository::class)
 */
class Faccoes
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
    private $faccao_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $cpf;

    /**
     * @ORM\Column(type="integer")
     */
    private $employees;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $bank;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $faccao_code;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $user_code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFaccaoName(): ?string
    {
        return $this->faccao_name;
    }

    public function setFaccaoName(string $faccao_name): self
    {
        $this->faccao_name = $faccao_name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getEmployees(): ?int
    {
        return $this->employees;
    }

    public function setEmployees(int $employees): self
    {
        $this->employees = $employees;

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

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(string $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getFaccaoCode(): ?string
    {
        return $this->faccao_code;
    }

    public function setFaccaoCode(string $faccao_code): self
    {
        $this->faccao_code = $faccao_code;

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

}
