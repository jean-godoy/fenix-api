<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\FinanceiroRepository;
use App\Entity\Financeiro;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Financeiro
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class FinanceiroService {

    /**
     * @var FinancerioRepository
     */

     protected $financeiroRepository;
     private $em;

     public function __construct(
         FinanceiroRepository   $finaceiroRepository,
         EntityManagerInterface $entityManagerInterface
     )
     {
         $this->financeiroRepository    = $finaceiroRepository;
         $this->em                      = $entityManagerInterface;
     }

     public function getAll()
     {
         $pagamentos = $this->financeiroRepository->findAll() ?? null;
         if($pagamentos === null || $pagamentos === ""){
             return  false;
         }

         return $pagamentos;
     }

     public function save(Array $data)
     {
        // var_dump($data); exit;
        $financeiro = new Financeiro;

        $data_entrega = new \DateTime($data['data_entrega']);
        $data_pagamento = new \DateTime($data['data_pagamento']);
        // var_dump($data_pagamento); exit();

        $financeiro->setDataEntraga($data_entrega);
        $financeiro->setDataPagamento($data_pagamento);
        $this->em->persist($financeiro);
        $this->em->flush();

        return true;
     }

     

 }