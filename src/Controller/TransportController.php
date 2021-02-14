<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Util\Traits\ResponseTrait;
use App\Service\TransportService;

/**
 * @Route("/api/transporte", name="api_")
 */
class TransportController extends AbstractController
{
    use ResponseTrait;
    private $transportService;

    public function __construct(
        TransportService $transportService
    )
    {
        $this->transportService = $transportService;
    }

   /**
    * @Route("/show", name="show", methods={"GET"})
    */
    public function show()
    {
        $response = $this->transportService->show();
        if($response === null || $response === "")
        {
            return $this->responseNotOK("Nenhum carga", false);
        }

        return $this->json($response, 200, [], []);
    }

    /**
     * @Route("/get-romaneios/{faccao_code}/{op}", name="romaneios", methods={"GET"})
     */
    public function geTromaneios($faccao_code, $op): Response
    {
        
        if($faccao_code === null || $faccao_code === "")
        {
            return $this->responseNotOK("Campo obrigatorio, faccao_code", false);
        }

        if($op === null || $op === "")
        {
            return $this->responseNotOK("Campo obrigatorio, op", false);
        }

        $response = $this->transportService->getRomaneio($faccao_code, $op);
        if($response === null || $response === "")
        {
            return $this->json("Nenhum romaneio corresponde a está O.P.", 200, [], []);
        }

        return $this->json($response, 200, [], []);
    }
}
