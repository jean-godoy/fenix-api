<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Util\Traits\ResponseTrait;
use App\Service\FaccaoRomaneioService;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/faccao-romaneios", name="faccaoRomaneio_")
 */
class FaccaoRomaneioController extends AbstractController
{
    use ResponseTrait;
    private $faccaoService;

    public function __construct(
        FaccaoRomaneioService $faccaoRomaneioService
    ) {
        $this->faccaoService = $faccaoRomaneioService;
    }

    /**
     * @Route("/list/{faccao_code}", name="list", methods={"GET"})
     */
    public function list($faccao_code): Response
    {
        $response = $this->faccaoService->list($faccao_code);

        return $this->json($response);
    }

    /**
     * para o app react
     * @Route("/get-list/{op}", name="getList", methods={"GET"})
     */
    public function getList(Request $request, $op)
    {
        $context['ignored_attributes'] = ['id', 'createdAt', 'deletedAt', 'updatedAt'];

        $faccao_code = $request->headers->get('Authorization') ?? null;
        if ($faccao_code === null || $faccao_code === "") {
            return $this->responseNotOK("Header obrigatorio, faccao_code", false);
        }

        if ($op === null || $op === "") {
            return $this->responseNotOK("Campo obrigatorio, op", false);
        }
       
        $romaneio = $this->faccaoService->getBy($faccao_code, $op);
        if ($romaneio === null || $romaneio === "") {
            return $this->responseNotOK("Nenhum romaneio correspondente ao O.P.", false);
        }
        
        $sequencia = $this->faccaoService->getSequenciaOp($romaneio["seguencia"]);
        $grade = $this->faccaoService->getGrade($romaneio['grade'], $op);

        return $this->json([
            "romaneio"  => $romaneio,
            "sequencia" => $sequencia,
            "grade"     => $grade
        ], 200, [], $context);
    }

     /**
      * para o app angular teste
     * @Route("/get-romaneio-list/{faccao_code}/{op}", name="getList", methods={"GET"})
     */
    public function getRomaneioList(Request $request, String $op, String $faccao_code)
    {
        $context['ignored_attributes'] = ['id', 'createdAt', 'deletedAt', 'updatedAt'];

        if ($faccao_code === null || $faccao_code === "") {
            return $this->responseNotOK("Paramentro obrogatorio faccao_code", false);
        }

        if ($op === null || $op === "") {
            return $this->responseNotOK("Paramentro obrigatorio, op", false);
        }
       
        $romaneio = $this->faccaoService->getBy($faccao_code, $op);
        if ($romaneio === null || $romaneio === "") {
            return $this->responseNotOK("Nenhum romaneio correspondente ao O.P.", false);
        }
        
        $sequencia = $this->faccaoService->getSequenciaOp($romaneio["seguencia"]);
        $grade = $this->faccaoService->getGrade($romaneio['grade'], $op);

        return $this->json([
            "romaneio"  => $romaneio,
            "sequencia" => $sequencia,
            "grade"     => $grade
        ], 200, [], $context);
    }

    /**
     * @Route("/set-status", name="setStatus", methods={"POST"})
     */
    public function setStatus(Request $request)
    {   
        $token = $request->headers->get('Authorization') ?? null;
        if($token === null || $token === "")
        {
            return $this->responseNotOK("Autorização obrigatoria, token", false);
        }

        $json = file_get_contents('php://input') ?? null;
        if($json === null || $json === "")
        {
            return $this->responseNotOK("Obrigatorio Objeto request json", false);
        }

        $data = json_decode($json, true);

        $response = $this->faccaoService->setStatus($data);
        if($response === false || $response === "")
        {
            return $this->responseNotOK("Erro ao atualizar o status, tente novamente", false);
        }
       
        return $this->json("Status atualizado com sucesso!", 200, [], []);

    }

    /**
     * @Route("/set-projecao-coleta", name="projecaoColeta", methods={"POST"})
     */
    public function projecaoColeta(): Response
    {
        $json = file_get_contents('php://input') ?? null;
        
        if($json === null || $json === "")
        {
            return $this->responseNotOK("ovrigatoria objeto de dados", false);
        }

        $data = json_decode($json, true);

        $response = $this->faccaoService->setPorjecaoColeta($data);

        if($response === false)
        {
            return "Problemas ao atualizar o projeção de coleta";
        }

        return $this->json("Projeção de coleta atualizada com sucesso!", 200, [], []);
    }

    public function projecaoColeta1(): Response
    {
        $json = file_get_contents('php://input') ?? null;
        
        if($json === null || $json === "")
        {
            return $this->responseNotOK("ovrigatoria objeto de dados", false);
        }

        $data = json_decode($json, true);

        $response = $this->faccaoService->setPorjecaoColeta($data);

        if($response === false)
        {
            return "Problemas ao atualizar o projeção de coleta";
        }

        return $this->json("Projeção de coleta atualizada com sucesso!", 200, [], []);
    }
}
