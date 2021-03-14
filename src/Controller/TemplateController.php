<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\FinalizacaoService;
use App\Util\Traits\ResponseTrait;
use App\Service\FaccaoRomaneioService;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/template", name="template_")
 */
class TemplateController extends AbstractController
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
     * @Route("/finalizacao", name="show", methods={"GET"})
     */
    public function show(): Response
    {
        $response = $this->finalizacaoService->getAll();

        return $this->render('finalizacao/finalizacao.html.twig', [
            'response' => $response,
            'success' => 'teste ok'
        ]);
    }

    /**
     * @Route("/finalizacao-get/{faccao_code}/{op}", name="getId", methods={"GET"})
     */
    public function getId($faccao_code, $op): Response
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

        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = $serializer->normalize($response, null);
        
        return $this->render('finalizacao/finalizacao-show.html.twig', [
            'response' => $data
        ]);
    }
}
