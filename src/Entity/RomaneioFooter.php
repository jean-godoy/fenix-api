<?php

namespace App\Entity;

use App\Repository\RomaneioFooterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RomaneioFooterRepository::class)
 */
class RomaneioFooter
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
     * @ORM\Column(type="string", length=255)
     */
    private $atencao;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $total_sem_int;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $total_com_int;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_pecas_hora;

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

    public function getAtencao(): ?string
    {
        return $this->atencao;
    }

    public function setAtencao(string $atencao): self
    {
        $this->atencao = $atencao;

        return $this;
    }

    public function getTotalSemInt(): ?string
    {
        return $this->total_sem_int;
    }

    public function setTotalSemInt(string $total_sem_int): self
    {
        $this->total_sem_int = $total_sem_int;

        return $this;
    }

    public function getTotalComInt(): ?string
    {
        return $this->total_com_int;
    }

    public function setTotalComInt(string $total_com_int): self
    {
        $this->total_com_int = $total_com_int;

        return $this;
    }

    public function getTotalPecasHora(): ?int
    {
        return $this->total_pecas_hora;
    }

    public function setTotalPecasHora(int $total_pecas_hora): self
    {
        $this->total_pecas_hora = $total_pecas_hora;

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
