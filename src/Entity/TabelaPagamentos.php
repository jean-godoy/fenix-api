<?php

namespace App\Entity;

use App\Repository\TabelaPagamentosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TabelaPagamentosRepository::class)
 */
class TabelaPagamentos
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
    private $data_entrega;

    /**
     * @ORM\Column(type="date")
     */
    private $data_pagamento;

    public function getId(): ?int
    {
        return $this->id;
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
