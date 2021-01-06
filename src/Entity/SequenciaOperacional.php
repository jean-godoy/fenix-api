<?php

namespace App\Entity;

use App\Repository\SequenciaOperacionalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SequenciaOperacionalRepository::class)
 */
class SequenciaOperacional
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $reference_code;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordemProducao;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $maquina;

    /**
     * @ORM\Column(type="integer")
     */
    private $sequencia;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operacao;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $tempo_sem_int;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $tempo_com_int;

    /**
     * @ORM\Column(type="integer")
     */
    private $pecas_hora;

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
     * @ORM\Column(type="integer")
     */
    private $num_nfe;

    /**
     * @ORM\Column(type="integer")
     */
    private $referencia;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferenceCode(): ?string
    {
        return $this->reference_code;
    }

    public function setReferenceCode(string $reference_code): self
    {
        $this->reference_code = $reference_code;

        return $this;
    }

    public function getMaquina(): ?string
    {
        return $this->maquina;
    }

    public function setMaquina(string $maquina): self
    {
        $this->maquina = $maquina;

        return $this;
    }

    public function getSequencia(): ?int
    {
        return $this->sequencia;
    }

    public function setSequencia(int $sequencia): self
    {
        $this->sequencia = $sequencia;

        return $this;
    }

    public function getOperacao(): ?string
    {
        return $this->operacao;
    }

    public function setOperacao(string $operacao): self
    {
        $this->operacao = $operacao;

        return $this;
    }

    public function getTempoSemInt(): ?string
    {
        return $this->tempo_sem_int;
    }

    public function setTempoSemInt(string $tempo_sem_int): self
    {
        $this->tempo_sem_int = $tempo_sem_int;

        return $this;
    }

    public function getTempoComInt(): ?string
    {
        return $this->tempo_com_int;
    }

    public function setTempoComInt(string $tempo_com_int): self
    {
        $this->tempo_com_int = $tempo_com_int;

        return $this;
    }

    public function getPecasHora(): ?int
    {
        return $this->pecas_hora;
    }

    public function setPecasHora(int $pecas_hora): self
    {
        $this->pecas_hora = $pecas_hora;

        return $this;
    }

    /**
     * Get the value of ordemProducao
     */ 
    public function getOrdemProducao()
    {
        return $this->ordemProducao;
    }

    /**
     * Set the value of ordemProducao
     *
     * @return  self
     */ 
    public function setOrdemProducao($ordemProducao)
    {
        $this->ordemProducao = $ordemProducao;

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

    public function getNumNfe(): ?int
    {
        return $this->num_nfe;
    }

    public function setNumNfe(int $num_nfe): self
    {
        $this->num_nfe = $num_nfe;

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
}
