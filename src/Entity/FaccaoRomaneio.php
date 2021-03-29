<?php

namespace App\Entity;

use App\Repository\FaccaoRomaneioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FaccaoRomaneioRepository::class)
 */
class FaccaoRomaneio
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
    private $faccao_code;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordem_producao;

    /**
     * @ORM\Column(type="text")
     */
    private $grade;

    /**
     * @ORM\Column(type="text")
     */
    private $seguencia;

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
     * @ORM\Column(type="string", length=32)
     */
    private $romaneio_code;

    /**
     * @ORM\Column(type="integer")
     */
    private $faccao_status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $status_updated;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $projecao_coleta;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $valor_faccao;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $iniciado;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $finalizado;

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

    public function getOrdemProducao(): ?int
    {
        return $this->ordem_producao;
    }

    public function setOrdemProducao(int $ordem_producao): self
    {
        $this->ordem_producao = $ordem_producao;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getSeguencia(): ?string
    {
        return $this->seguencia;
    }

    public function setSeguencia(string $seguencia): self
    {
        $this->seguencia = $seguencia;

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

    /**
     * Get the value of romaneio_code
     */ 
    public function getRomaneioCode()
    {
        return $this->romaneio_code;
    }

    /**
     * Set the value of romaneio_code
     *
     * @return  self
     */ 
    public function setRomaneioCode($romaneio_code)
    {
        $this->romaneio_code = $romaneio_code;

        return $this;
    }

    public function getFaccaoStatus(): ?int
    {
        return $this->faccao_status;
    }

    public function setFaccaoStatus(int $faccao_status): self
    {
        $this->faccao_status = $faccao_status;

        return $this;
    }

    public function getStatusUpdated(): ?\DateTimeInterface
    {
        return $this->status_updated;
    }

    public function setStatusUpdated(?\DateTimeInterface $status_updated): self
    {
        $this->status_updated = $status_updated;

        return $this;
    }

    public function getProjecaoColeta(): ?\DateTimeInterface
    {
        return $this->projecao_coleta;
    }

    public function setProjecaoColeta(?\DateTimeInterface $projecao_coleta): self
    {
        $this->projecao_coleta = $projecao_coleta;

        return $this;
    }

    public function getValorFaccao(): ?string
    {
        return $this->valor_faccao;
    }

    public function setValorFaccao(string $valor_faccao): self
    {
        $this->valor_faccao = $valor_faccao;

        return $this;
    }

    public function getIniciado(): ?\DateTimeInterface
    {
        return $this->iniciado;
    }

    public function setIniciado(?\DateTimeInterface $iniciado): self
    {
        $this->iniciado = $iniciado;

        return $this;
    }

    public function getFinalizado(): ?\DateTimeInterface
    {
        return $this->finalizado;
    }

    public function setFinalizado(?\DateTimeInterface $finalizado): self
    {
        $this->finalizado = $finalizado;

        return $this;
    }
}
