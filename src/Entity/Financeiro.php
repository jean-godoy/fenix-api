<?php

namespace App\Entity;

use App\Repository\FinanceiroRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FinanceiroRepository::class)
 */
class Financeiro
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $data_entraga;

    /**
     * @ORM\Column(type="date")
     */
    private $data_pagamento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataEntraga(): ?\DateTimeInterface
    {
        return $this->data_entraga;
    }

    public function setDataEntraga(\DateTimeInterface $data_entraga): self
    {
        $this->data_entraga = $data_entraga;

        return $this;
    }

    public function getDataPagamento(): ?\DateTimeInterface
    {
        return $this->data_pagamento;
    }

    public function setDataPagamento(\DateTimeInterface $data_pagamento): self
    {
        $this->data_pagamento = $data_pagamento;

        return $this;
    }
}
