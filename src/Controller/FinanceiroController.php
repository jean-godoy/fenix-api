<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Util\Traits\ResponseTrait;

use App\Service\FinanceiroService;

/**
 * @Route("/financeiro", name="financeiro_")
 */
class FinanceiroController extends AbstractController
{
    use ResponseTrait;

    private $financeiroService;

    public function __construct(
        FinanceiroService $financeiroService
    )
    {
        $this->financeiroService = $financeiroService;
    }

    /**
     * @Route("/show", name="show", methods={"GET"})
     */
    public function show(): Response
    {
        $response = $this->financeiroService->showTabelaPagamentos();
        if($response === false || $response === []){
            return $this->responseNotOK([
                "response"  => "Nenhuma data cadastrada!",
                "error"     => false
            ], false);
        }

        return $this->json($response, 200, [], []);
    }

    /**
     * @Route("/adicionar-pagamento", name="add" , methods={"POST"})
     */
    public function add(): Response
    {
        $json = file_get_contents('php://input') ?? null;
        if($json === null || $json === ""){
            return $this->responseNotOK("Objeto de data obrigatorio", false);
        }

        $data = json_decode($json, true);
        
        $response = $this->financeiroService->saveDataPagamento($data);
        if($response !== true){
            return $this->responseNotOK("Erro ao cadastrar datas!", false);
        }

        return $this->json($response, 200, [], []);
    }

    /**
     * Rota que retorna todas folhas de pagamentos válidas 
     * agrupadas pelas NFE.
     * 
     * @Route("/get-payroll-by-nfe", name=" getPayrollByNfe", methods={"GET"})
     */
    public function getPayrollByNfe(): Response
    {
        $response = $this->financeiroService->getPayrollsValidByNef();
        

        return $this->json($response, 200, [], []);
    }

    /**
     * Pega todas folhas de pagamento vinculadas a uma NFE.
     * 
     * @Route("/get-payrolls-reffering-to/{nfe}", name="getPayrollsReferringToNfe", methods={"GET"})
     */
    public function getPayrollsReferringToNfe(int $nfe): Response
    {
        if($nfe === null || $nfe === "")
        {
            return $this->responseNotOK("Parametro obrigatório, nfe.", false);
        }

        $response = $this->financeiroService->getPayrollsReferringToNfe($nfe);

        return $this->json($response, 200, [], []);
    }

    /**
     * Funnção que altera o status da folha de pagamento
     * 
     * @Route("/update-status-payroll/{op}", name="updateStatusPayroll", methods={"PATCH"})
     */
    public function updateStatusPayroll(int $op): Response 
    {   
        $response = $this->financeiroService->updateStatuspayroll($op);

        return $this->json($response, 200, [], []);
    }
}
