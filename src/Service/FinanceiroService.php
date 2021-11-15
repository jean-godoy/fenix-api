<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\FinanceiroRepository;
use App\Entity\Financeiro;
use App\Entity\Payroll;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\TabelaPagamentosRepository;
use App\Repository\PayrollRepository;
use App\Entity\TabelaPagamentos;

/**
 * Class Financeiro
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

class FinanceiroService
{

    /**
     * @var FinancerioRepository
     */

    protected $financeiroRepository;
    protected $tabelaPagamentos;
    protected $payrollRepository;
    private $em;

    public function __construct(
        FinanceiroRepository       $finaceiroRepository,
        EntityManagerInterface     $entityManagerInterface,
        TabelaPagamentosRepository $tabelaPagamentosRepository,
        PayrollRepository          $payrollRepository
    ) {
        $this->financeiroRepository    = $finaceiroRepository;
        $this->em                      = $entityManagerInterface;
        $this->tabelaPagamentos        = $tabelaPagamentosRepository;
        $this->payrollRepository       = $payrollRepository;
    }

    public function showTabelaPagamentos()
    {
        $pagamentos = $this->tabelaPagamentos->findAll() ?? null;
        if ($pagamentos === null || $pagamentos === "") {
            return  false;
        }

        return $pagamentos;
    }

    //  public function save(Array $data)
    //  {
    //     // var_dump($data); exit;
    //     $financeiro = new Financeiro;

    //     $data_entrega = new \DateTime($data['data_entrega']);
    //     $data_pagamento = new \DateTime($data['data_pagamento']);
    //     // var_dump($data_pagamento); exit();

    //     $financeiro->setDataEntraga($data_entrega);
    //     $financeiro->setDataPagamento($data_pagamento);
    //     $this->em->persist($financeiro);
    //     $this->em->flush();

    //     return true;
    //  }

    public function saveDataPagamento(array $data)
    {
        $pagamentos = new TabelaPagamentos;

        $data = str_replace('/', '-', $data);

        $data_entrega = new \DateTime($data['data_entrega']);
        $data_pagamento = new \DateTime($data['data_pagamento']);

        $pagamentos->setDataEntrega(new \DateTime($data['data_entrega']));
        $pagamentos->setDataPagamento($data_pagamento);

        $this->em->persist($pagamentos);
        $this->em->flush();

        return true;
    }

    /**
     * Faz uma consulta no banco e retorna todas
     * folhas de pagamentos validas.
     */
    public function getPayrollsValidByNef()
    {
        //cria uma conexção.
        $conn = $this->em->getConnection();

        $sql = "SELECT nfe FROM payroll WHERE status_pagamento = false GROUP BY nfe";
        $sql = $conn->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
            return $response;
        }


        return false;
    }

    /**
     * Metodo que retorna todos romaneios vinculados a uma NFE
     */
    public function getPayrollsReferringToNfe(int $nfe)
    {
        $conn = $this->em->getConnection();

        $sql = "SELECT * FROM payroll WHERE status_pagamento = false AND nfe = '$nfe'";
        $sql = $conn->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
            return $response;
        }


        return false;        
    }

    /**
     * Metodo que altera o status de pagamento.
     */
    public function updateStatusPayroll(int $op)
    {
        $payroll = $this->payrollRepository->findOneBy(["ordem_producao" => $op]);
        $payroll->setStatusPagamento(1);

        $this->em->flush();

        return true;
    }
}
