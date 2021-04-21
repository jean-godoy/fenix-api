<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Faccoes;
use App\Repository\SequenciaOperacionalRepository;
use App\Service\RomaneioService;
use App\Service\EstoqueService;
use App\Util\Traits\ResponseTrait;
use App\Service\CheckOpService;
use App\Entity\SequenciaOperacional;



/**
 * @Route("/romaneios", name="romaneio_")
 */
class RomaneioController extends AbstractController
{
    use ResponseTrait;
    private $romaneioService;
    private $estoqueService;
    private $checkOpService;
    
    public function __construct(
        RomaneioService             $romaneioService,
        EstoqueService              $estoqueService,
        CheckOpService              $checkOpService
    )
    {
        $this->romaneioService      = $romaneioService;
        $this->estoqueService       = $estoqueService;
        $this->checkOpService       = $checkOpService;    
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();

        $sql = "SELECT * FROM checking WHERE status = 2";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            $romaneio = $stmt->fetchAll();
        }else {
            $romaneio = "Nenhum Romaneio Cadastrado";
        }

        return $this->json(
           $romaneio
        );
    }

    /**
     * @Route("/get-op/{op}", name="getOp", methods={"GET"})
     */
    public function getOp($op)
    {
        $context['ignored_attributes'] = ['createdAt', 'deletedAt', 'updatedAt'];
        $romaneio = $this->romaneioService->getRomaneio($op);

        if($romaneio === null || $romaneio === "")
        {
            return $this->responseNotOK("Nenhum romaneio corresponde a O.P.", false);
        }

        return $this->json($romaneio, 200, [], $context);
    }

    /**
     * @Route("/expedicao/{op}", name="romaneioExpedicao", methods={"GET"})
     */
    public function romaneioExpedicao($op)
    {
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();

        $sql = "SELECT * FROM grade_romaneio WHERE op = $op";
        $sql = $conn->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0)
        {
            $romaneio = $sql->fetchAll();
        }else {
            $romaneio = "Nenhum Romaneio Corresponde a essa OP!";
        }

        return $this->json($romaneio);
    }

    /**
     * @Route("/get-faccoes", name="getFaccaoes", methods={"GET"})
     */
    public function getFaccoes()
    {
        $faccoes = $this->getDoctrine()->getRepository(Faccoes::class)->findAll();

        return $this->json($faccoes);
    }

    /**
     * @Route("/check-op/{op}", name="checkOp", methods={"GET"})
     */
    public function checkOp($op): Response
    {
        if($op === null || $op === "")
        {
            return $this->responseNotOK("Campo obrigatório, op", false);
        }

        $response = $this->checkOpService->checkOp($op);

        if($response === false || $response === "")
        {
            return $this->json(false, 201, [], []);
        }

        return $this->json($response, 200, [], []);
    }

    /**
     * @Route("/get-romaneio/{op}", name="getRomaneio", methods={"GET"})
     */
    public function getRomaenio($op)
    {
        $context['ignored_attributes'] = ['createdAt', 'deletedAt', 'updatedAt'];

        if($op === null || $op === "")
        {
            return $this->responseNotOK("Campo Obrigatorio, Ordem de Produção", false);
        }

        $romaneio = $this->estoqueService->checkOp($op);

        if($romaneio === null || $romaneio === "")
        {
            return $this->responseNotOK("Romaneio não cadastrado ou inexistente", false);
        }

        $grade = $this->estoqueService->getGrade($op);
        if($grade === null || $grade === "")
        {
            return $this->responseNotOK("Grade não cadastrado ou inexistente", false);
        }

        $seq_operacional = $this->estoqueService->getSequencia($op);
        if($seq_operacional === null || $seq_operacional === "")
        {
            return $this->responseNotOK("Sequencia Operacional não cadastrado ou inexistente", false);
        }

        $footer = $this->estoqueService->getFooter($op);
        if($footer === null || $footer === "")
        {
            return $this->responseNotOK("Romaneio Footer não cadastrado ou inexistente", false);
        }

        return $this->json([
            "romaneio"                  => $romaneio,
            "grade"                     => $grade,
            "sequencia_operacional"     => $seq_operacional,
            "footer"                    => $footer
        ], 200, [], $context);
    }

    /**
     * @Route("/reference-code", name="referenceCode", methods={"GET"})
     */
    public function referenceCode(){

        $reference_code = md5(uniqid(rand() . "", true));

        return $this->json($reference_code);
    }

    /**
     * @Route("/gerar-romaneio", name="gerarRomaneio", methods={"POST"}) 
     */
    public function gererRomaneio()
    {
        $context['ignored_attributes'] = ['id', 'createdAt', 'deletedAt', 'updatedAt'];

        $json = file_get_contents('php://input');
        $array = json_decode($json, TRUE );

        $doctrine = $this->getDoctrine();
            
        $response = $this->romaneioService->save($array, $doctrine) ?? null;
        if($response === null || $response === "")
        {
            return $this->responseNotOK("Nenhum dado registrado correspondente!", false);
        }

       foreach($array['sequencia'] as $item) {
        $sequencia = $doctrine->getRepository(SequenciaOperacional::class)->findOneBy(["reference_code" => $item]);
        $sequencia->setChecked(true);
        $maneger = $doctrine->getManager();
        $maneger->flush();
       }
    
        
        return $this->json($response, 200, [], $context);
    }

    /**
     * @Route("/get-romaneios-by-nfe/{nfe}", name="romaneioNfe", methods={"GET"})
     */
    public function romaneioNfe($nfe): Response
    {  
         $context['ignored_attributes'] = ['createdAt', 'deletedAt', 'updatedAt'];
        $response = $this->romaneioService->getRomaneioByNfe($nfe) ?? null;
        if($response === null || $response === "")
        {
            return $this->responseNotOK("Nenhum romaneio cadastrado!", false);
        }

        return $this->json($response, 200, [], $context);
    }

     /**
     * @Route("/financeiro-finalizados-lista/{nfe}", name="financeiroRomaneioList", methods={"GET"})
     */
    public function financeiroRomaneioList($nfe): Response
    {  
         $context['ignored_attributes'] = ['createdAt', 'deletedAt', 'updatedAt'];
        $response = $this->romaneioService->getFinanceiroRomaneioByNfe($nfe) ?? null;
        if($response === null || $response === "")
        {
            return $this->responseNotOK("Nenhum romaneio cadastrado!", false);
        }

        return $this->json($response, 200, [], $context);
    }

     /**
     * @Route("/list", name="list", methods={"GET"})
     */
    public function list()
    {  
         $context['ignored_attributes'] = ['createdAt', 'deletedAt', 'updatedAt'];
        $response = $this->romaneioService->nfeList() ?? null;
        if($response === null || $response === "")
        {
            return $this->responseNotOK("Nenhum romaneio cadastrado!", false);
        }

        return $this->json($response, 200, [], $context);
    }
    
}
