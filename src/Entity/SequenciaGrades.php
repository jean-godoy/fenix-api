<?php

namespace App\Entity;

use App\Repository\SequenciaGradesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SequenciaGradesRepository::class)
 */
class SequenciaGrades
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
     * @ORM\Column(type="string", length=10)
     */
    private $grade;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantidade;

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
     * @ORM\Column(type="string", length=32)
     */
    private $grade_code;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $checked;

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

    public function getGradeCode(): ?string
    {
        return $this->grade_code;
    }

    public function setGradeCode(string $grade_code): self
    {
        $this->grade_code = $grade_code;

        return $this;
    }

    public function getChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(?bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }
}
