<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @ORM\Column(type="float", precision=5, scale=5)
     */
    private $tempo_com_int;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTempoComInt(): ?float
    {
        return $this->tempo_com_int;
    }

    public function setTempoComInt(float $tempo_com_int): self
    {
        $this->tempo_com_int = $tempo_com_int;

        return $this;
    }
}
