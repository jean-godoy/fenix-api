<?php

namespace App\Entity;

use App\Repository\FormPaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormPaymentRepository::class)
 */
class FormPayment
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
    private $status;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $form_payment;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $faccao_code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFormPayment(): ?string
    {
        return $this->form_payment;
    }

    public function setFormPayment(string $form_payment): self
    {
        $this->form_payment = $form_payment;

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
}
