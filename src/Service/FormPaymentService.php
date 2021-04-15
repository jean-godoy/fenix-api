<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\FormPayment;
use App\Repository\FormPaymentRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FormPayment
 * @package App\Entity
 * @author Jean GOdoy
 * @link https:www.seidesistemas.com.br
 */

 class FormPaymentService {

    /**
     * @var FormPaymentRepository
     */

     protected  $paymentRepository;
     private    $em;

     public function __construct(
         FormPaymentRepository  $formPaymentRepository,
         EntityManagerInterface $entityManagerInterface
     )
     {
         $this->em                  = $entityManagerInterface;
         $this->paymentRepository   = $formPaymentRepository;
     }

     /**
      * Pega o status da forma de pagamento pelo 
      * faccao_code
      * @param string faccao_code
      * @return JSON
      */
      public function getForm(String $faccao_code)
      {
        return $this->paymentRepository->findOneBy(["faccao_code" => $faccao_code]) ?? null;
      }

      /**
       * Salva os dados no banco
       * @return []
       */
      public function save(array $data)
      {
          $payment = new FormPayment();
          $payment->setStatus($data['status']);
          $payment->setFormPayment($data['form_payment']);
          $payment->setFaccaoCode($data['faccao_code']);

          $this->em->persist($payment);
          $this->em->flush();
          return [];
      }

      /**
       * Faz update no banco
       * @return []
       */
      public function update($data)
      {
          $payment = $this->paymentRepository->findOneBy(["faccao_code" => $data['faccao_code']]);
          $payment->setStatus($data['status']);
          $payment->setFormPayment($data['form_payment']);

          $this->em->flush();
          
          return true;
      }

 }