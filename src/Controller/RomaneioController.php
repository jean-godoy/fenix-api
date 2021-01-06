<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Checking;
use App\Entity\GradeRomaneio;
use App\Entity\Faccoes;

use App\Service\RomaneioService;
use App\Service\EstoqueService;
use App\Util\Traits\ResponseTrait;

/**
 * @Route("/romaneios", name="romaneio_")
 */
class RomaneioController extends AbstractController
{
    use ResponseTrait;
    private $romaneioService;
    private $estoqueService;
    
    public function __construct(
        RomaneioService             $romaneioService,
        EstoqueService              $estoqueService
    )
    {
        $this->romaneioService      = $romaneioService;
        $this->estoqueService       = $estoqueService;
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
}
