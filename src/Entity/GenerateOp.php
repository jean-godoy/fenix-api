<?php

namespace App\Entity;

use App\Repository\GenerateOpRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GenerateOpRepository::class)
 */
class GenerateOp
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $op;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fornecedor;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $referencia;

    /**
     * @ORM\Column(type="integer")
     */
    private $cor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\Column(type="integer")
     */
    private $semana;

    /**
     * @ORM\Column(type="integer")
     */
    private $os;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantidade;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $preco_unitario;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $desc_service;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data_in;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOp(): ?int
    {
        return $this->op;
    }

    public function setOp(int $op): self
    {
        $this->op = $op;

        return $this;
    }

    public function getFornecedor(): ?string
    {
        return $this->fornecedor;
    }

    public function setFornecedor(string $fornecedor): self
    {
        $this->fornecedor = $fornecedor;

        return $this;
    }

    public function getReferencia(): ?string
    {
        return $this->referencia;
    }

    public function setReferencia(string $referencia): self
    {
        $this->referencia = $referencia;

        return $this;
    }

    public function getCor(): ?int
    {
        return $this->cor;
    }

    public function setCor(int $cor): self
    {
        $this->cor = $cor;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getSemana(): ?int
    {
        return $this->semana;
    }

    public function setSemana(int $semana): self
    {
        $this->semana = $semana;

        return $this;
    }

    public function getOs(): ?int
    {
        return $this->os;
    }

    public function setOs(int $os): self
    {
        $this->os = $os;

        return $this;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): self
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    public function getPrecoUnitario(): ?string
    {
        return $this->preco_unitario;
    }

    public function setPrecoUnitario(string $preco_unitario): self
    {
        $this->preco_unitario = $preco_unitario;

        return $this;
    }

    public function getDescService(): ?string
    {
        return $this->desc_service;
    }

    public function setDescService(string $desc_service): self
    {
        $this->desc_service = $desc_service;

        return $this;
    }

    public function getDataIn(): ?\DateTimeInterface
    {
        return $this->data_in;
    }

    public function setDataIn(\DateTimeInterface $data_in): self
    {
        $this->data_in = $data_in;

        return $this;
    }
}
