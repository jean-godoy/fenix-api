<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\FinalizacaoService;
use App\Util\Traits\ResponseTrait;
use App\Service\FaccaoRomaneioService;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;

use App\Service\SessionService;

/**
 * @Route("/template", name="template_")
 */
class TemplateController extends AbstractController
{
    use ResponseTrait;

    private $finalizacaoService;
    private $faccaoRomaneioService;
    private $session;

    public function __construct(
        FinalizacaoService      $finalizacaoService,
        FaccaoRomaneioService   $faccaoRomaneioService,
        SessionService          $sessionService
    ) {
        $this->finalizacaoService       = $finalizacaoService;
        $this->faccaoRomaneioService    = $faccaoRomaneioService;
        $this->session                  = $sessionService;
    }

    /**
     * @Route("/home", name="home", methods={"GET"})
     */
    public function home(): Response
    {
        $token = $this->session->checked();
        if ($token === null) {
            
            return $this->redirect('/', 308);
        }

        return $this->render('main/main.html.twig');
    }

    /**
     * @Route("/finalizacao", name="show", methods={"GET"})
     */
    public function show(): Response
    {
        $token = $this->session->checked();
        if ($token === null) {
            
            return $this->redirect('/', 308);
        }
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
        $token = $this->session->checked();
        if ($token === null) {
            
            return $this->redirect('/', 308);
        }

        if ($faccao_code === null || $faccao_code === "") {
            return $this->responseNotOK("Parametro obrigatório, faccao_code");
        }

        if ($op === null || $op === "") {
            return $this->responseNotOK("Parametro obrigatório, op");
        }

        $response = $this->finalizacaoService->getBy($faccao_code, $op);

        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = $serializer->normalize($response, null);

        return $this->render('finalizacao/finalizacao-show.html.twig', [
            'response' => $data
        ]);
    }

    /**
     * @Route("/sair", name="logout", methods={"GET"})
     */
    public function logout(): Response
    {
        $token = $this->session->checked();
        if ($token === null) {
            
            return $this->redirect('/', 308);
        }

        return $this->render('login/logout.html.twig');
    }

    /**
     * @Route("/cancelar", name="voltar", methods={"GET"})
     */
    public function voltar()
    {
        $token = $this->session->checked();
        if ($token === null) {
            
            return $this->redirect('/', 308);
        }
        
        return $this->render('main/main.html.twig');
    }

    /**
     * @Route("/logout", name="sair",methods={"GET"})
     */
    public function sair()
    {
        $token = $this->session->checked();
        if ($token === null) {
            
            return $this->redirect('/', 308);
        }

        $destroy = $this->session->destroy();
        return $this->render('login/login.html.twig');
    }
}
