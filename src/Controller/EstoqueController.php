<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\RomaneioDescricaoRepository;
use App\Repository\SequenciaGradesRepository;
use App\Repository\SequenciaOperacionalRepository;

use App\Util\Traits\ResponseTrait;

use App\Service\EstoqueService;

/**
 * @Route("/estoque", name="estoque_")
 */
class EstoqueController extends AbstractController
{
    use ResponseTrait;
    private $romaneioRepository;
    private $gradeRepository;
    private $sequenciaRepository;
    private $estoqueService;

    public function __construct(
        RomaneioDescricaoRepository     $romaneioRepository,
        SequenciaGradesRepository       $gradeRepository,
        SequenciaOperacionalRepository  $sequenciaRepository,
        EstoqueService                  $estoqueService
    ) {
        $this->romaneioRepository       = $romaneioRepository;
        $this->gradeRepository          = $gradeRepository;
        $this->sequenciaRepository      = $sequenciaRepository;
        $this->estoqueService           = $estoqueService;
    }

    /**
     * @Route("/get-id/{op}", name="estoque", methods={"GET"})
     */
    public function estoque($op): Response
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
}
