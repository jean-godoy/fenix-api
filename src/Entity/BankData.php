<?php

namespace App\Entity;

use App\Repository\BankDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BankDataRepository::class)
 */
class BankData
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
    private $faccao_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome_titular;

    /**
     * @ORM\Column(type="bigint")
     */
    private $cpf_titular;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $banco;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $agencia;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $conta;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted_at;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNomeTitular(): ?string
    {
        return $this->nome_titular;
    }

    public function setNomeTitular(string $nome_titular): self
    {
        $this->nome_titular = $nome_titular;

        return $this;
    }

    public function getCpfTitular(): ?int
    {
        return $this->cpf_titular;
    }

    public function setCpfTitular(int $cpf_titular): self
    {
        $this->cpf_titular = $cpf_titular;

        return $this;
    }

    public function getBanco(): ?string
    {
        return $this->banco;
    }

    public function setBanco(string $banco): self
    {
        $this->banco = $banco;

        return $this;
    }

    public function getAgencia(): ?string
    {
        return $this->agencia;
    }

    public function setAgencia(string $agencia): self
    {
        $this->agencia = $agencia;

        return $this;
    }

    public function getConta(): ?string
    {
        return $this->conta;
    }

    public function setConta(string $conta): self
    {
        $this->conta = $conta;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }
}
