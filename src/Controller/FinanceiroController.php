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
        $response = $this->financeiroService->getAll();
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
        
        $response = $this->financeiroService->save($data);
        if($response !== true){
            return $this->responseNotOK("Erro ao cadastrar datas!", false);
        }

        return $this->json($response, 200, [], []);
    }
}
