<?php

namespace App\Entity;

use App\Repository\FaccaoGradesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FaccaoGradesRepository::class)
 */
class FaccaoGrades
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
    private $num_controle;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $faccao_code;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $grade;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantidade;

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

    public function getNumControle(): ?int
    {
        return $this->num_controle;
    }

    public function setNumControle(int $num_controle): self
    {
        $this->num_controle = $num_controle;

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

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

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
}
