<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Util\Traits\ResponseTrait;
use App\Service\BankDataService;

/**
 * @Route("/api/bank-data", name="bank_data_")
 */
class BankDataController extends AbstractController
{
    use ResponseTrait;

    private $bankDataService;

    public function __construct(
        BankDataService $bankDataService
    ) {
        $this->bankDataService = $bankDataService;
    }

    /**
     * @Route("/get-data/{faccao_code}", name="getBy", methods={"GET"})
     */
    public function getBy($faccao_code): Response
    {
        $response = $this->bankDataService->show($faccao_code);
        if($response === false || $response === "")
        {
            return $this->responseNotOK(null, false);
        }
       
        return $this->json($response);
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $json = file_get_contents('php://input') ?? null;
        if($json === null || $json === "")
        {
            return $this->responseNotOK('Objeto JSON obrigatorio!', false);
        }

        $data = json_decode($json, true);

        $response = $this->bankDataService->generate($data);

        return $this->json([]);
    }

}
