<?php

namespace App\Entity;

use App\Repository\RomaneioDescricaoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RomaneioDescricaoRepository::class)
 */
class RomaneioDescricao
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
     * @ORM\Column(type="integer")
     */
    private $referencia;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cor;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $descricao_servico;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data;

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
     * @ORM\Column(type="string", precision=10, scale=2)
     */
    private $valor;

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

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $tipo;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_nfe;

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

    public function getReferencia(): ?int
    {
        return $this->referencia;
    }

    public function setReferencia(int $referencia): self
    {
        $this->referencia = $referencia;

        return $this;
    }

    public function getCor(): ?int
    {
        return $this->cor;
    }

    public function setCor(?int $cor): self
    {
        $this->cor = $cor;

        return $this;
    }

    public function getDescricaoServico(): ?string
    {
        return $this->descricao_servico;
    }

    public function setDescricaoServico(string $descricao_servico): self
    {
        $this->descricao_servico = $descricao_servico;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

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

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

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

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getNumNfe(): ?int
    {
        return $this->num_nfe;
    }

    public function setNumNfe(int $num_nfe): self
    {
        $this->num_nfe = $num_nfe;

        return $this;
    }
}
