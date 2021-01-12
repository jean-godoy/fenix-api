<?php

namespace App\Entity;

use App\Repository\FaccaoSequenciaOperacionalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FaccaoSequenciaOperacionalRepository::class)
 */
class FaccaoSequenciaOperacional
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
     * @ORM\Column(type="string", length=32)
     */
    private $faccao_code;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $reference_code;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $maquina;

    /**
     * @ORM\Column(type="integer")
     */
    private $sequencia;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $tempo_sem_int;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $tempo_com_int;

    /**
     * @ORM\Column(type="integer")
     */
    private $pecas_hora;

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

    public function getFaccaoCode(): ?string
    {
        return $this->faccao_code;
    }

    public function setFaccaoCode(string $faccao_code): self
    {
        $this->faccao_code = $faccao_code;

        return $this;
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
}
