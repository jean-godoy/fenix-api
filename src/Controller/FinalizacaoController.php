<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\FinalizacaoService;
use App\Util\Traits\ResponseTrait;
use App\Service\FaccaoRomaneioService;


/**
 * @Route("/api/finalizacao", name="api_")
 */
class FinalizacaoController extends AbstractController
{
    use ResponseTrait;

    private $finalizacaoService;
    private $faccaoRomaneioService;

    public function __construct(
        FinalizacaoService      $finalizacaoService,
        FaccaoRomaneioService   $faccaoRomaneioService
    )
    {
        $this->finalizacaoService       = $finalizacaoService;
        $this->faccaoRomaneioService    = $faccaoRomaneioService;
    }

    /**
     * @Route("/get-all", name="getAll", methods={"GET"})
     */
    public function getAll(): Response
    {
        $response = $this->finalizacaoService->getAll();
        if($response === false){
            return $this->responseNotOK("Nenhum romaneio");
        }

        return $this->json($response, 200, [], []);
    }

    /**
     * @Route("/get-romaneio/{faccao_code}/{op}", name="getBy", methods={"GET"})
     */
    public function getBy($faccao_code, $op): Response
    {
        if($faccao_code === null || $faccao_code === "")
        {
            return $this->responseNotOK("Parametro obrigatório, faccao_code");
        }

        if($op === null || $op === "")
        {
            return $this->responseNotOK("Parametro obrigatório, op");
        }

        $response = $this->finalizacaoService->getBy($faccao_code, $op);

        return $this->json($response, 200, [], []);
    }

    /**
     * @Route("/set-status", name="setStatus", methods={"POST"})
     */
    public function setStatus()
    {
        $json = file_get_contents('php://input');
        var_dump($json);
        $array = json_decode($json, true);

        if(!is_array($array))
        {
            return $this->responseNotOK("Objeto json obrigatorio!");
        }

        $response = $this->faccaoRomaneioService->setStatus($array);
        if($response === null || $response === "")
        {
            return $this->json("Erro ao atualizar o status", 401, [], []);
        }

        return $this->json("Status atualizado com sucesso!", 200, [], []);

    }
}
