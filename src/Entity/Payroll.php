<?php

namespace App\Entity;

use App\Repository\PayrollRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PayrollRepository::class)
 */
class Payroll
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
    private $ordem_producao;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $faccao_nome;

    /**
     * @ORM\Column(type="integer")
     */
    private $ref;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $desc_servico;

    /**
     * @ORM\Column(type="date")
     */
    private $data_entrega;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $preco;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantidade;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $valor_total;

    /**
     * @ORM\Column(type="date")
     */
    private $data_pamento;

    /**
     * @ORM\Column(type="integer")
     */
    private $status_pagamento;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $faccao_code;

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

    public function getOrdemProducao(): ?int
    {
        return $this->ordem_producao;
    }

    public function setOrdemProducao(int $ordem_producao): self
    {
        $this->ordem_producao = $ordem_producao;

        return $this;
    }

    public function getFaccaoNome(): ?string
    {
        return $this->faccao_nome;
    }

    public function setFaccaoNome(string $faccao_nome): self
    {
        $this->faccao_nome = $faccao_nome;

        return $this;
    }

    public function getRef(): ?int
    {
        return $this->ref;
    }

    public function setRef(int $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getDescServico(): ?string
    {
        return $this->desc_servico;
    }

    public function setDescServico(string $desc_servico): self
    {
        $this->desc_servico = $desc_servico;

        return $this;
    }

    public function getDataEntrega(): ?\DateTimeInterface
    {
        return $this->data_entrega;
    }

    public function setDataEntrega(\DateTimeInterface $data_entrega): self
    {
        $this->data_entrega = $data_entrega;

        return $this;
    }

    public function getPreco(): ?string
    {
        return $this->preco;
    }

    public function setPreco(string $preco): self
    {
        $this->preco = $preco;

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

    public function getValorTotal(): ?string
    {
        return $this->valor_total;
    }

    public function setValorTotal(string $valor_total): self
    {
        $this->valor_total = $valor_total;

        return $this;
    }

    public function getDataPamento(): ?\DateTimeInterface
    {
        return $this->data_pamento;
    }

    public function setDataPamento(\DateTimeInterface $data_pamento): self
    {
        $this->data_pamento = $data_pamento;

        return $this;
    }

    public function getStatusPagamento(): ?int
    {
        return $this->status_pagamento;
    }

    public function setStatusPagamento(int $status_pagamento): self
    {
        $this->status_pagamento = $status_pagamento;

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

    public function setDeletedAt(?\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }
}
