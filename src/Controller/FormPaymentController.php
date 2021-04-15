<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\FormPaymentService;
use App\Util\Traits\ResponseTrait;

/**
 * @Route("/api/form-payment", name="form-paiment_")
 */
class FormPaymentController extends AbstractController
{
    use ResponseTrait;
    private Object $paymentService;

    public function __construct(
        FormPaymentService $formPaymentService
    )
    {   
        $this->paymentService = $formPaymentService;
    }

    /**
     * Retorna status atual da forma de pagamento 
     * da facção pelo faccao_code
     * 
     * @Route("/payment-status/{faccao_code}", name="payment_status", methods={"GET"})
     * 
     * @param string $reference_code
     * @return JSON[]
     */
    public function payment_status($faccao_code): Response
    {
        $res = $this->paymentService->getForm($faccao_code);

        return $this->json($res, 200 , [], []);
    }

    /**
     * Faz o cadastro no banco
     * @Route("/create", name="create", methods={"POST"})
     * 
     * @return boolean
     */
    public function create(): Response {
        $json = file_get_contents('php://input') ?? null;
        if($json === null || $json === "")
        {
            return $this->responseNotOK("Objeto obrigatorio", false);
        }

        $data = json_decode($json, true);
        $response = $this->paymentService->save($data);

        return $this->json(true, 200, [],[]);
    }

    /**
     * Salva a alteração de status
     * 
     * @Route("/update", name="update", methods={"PUT"})
     * 
     * @param JSON
     * @return boolean
     */
    public function update(): Response {

        $json = file_get_contents('php://input') ?? null;
        if($json === null || $json === "") 
        {
            return $this->responseNotOK("Objeto Obrigatorio", false);
        }

        $data = json_decode($json, true);
       $response = $this->paymentService->update($data);

        return $this->json([], 200, [], []);
    }
}
