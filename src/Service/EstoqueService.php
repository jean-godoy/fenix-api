<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\RomaneioDescricaoRepository;
use App\Repository\SequenciaGradesRepository;
use App\Repository\SequenciaOperacionalRepository;
use App\Repository\RomaneioFooterRepository;

/**
 * Class EstoqueService
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class EstoqueService
 {

    /**
     * @var RomaneioDescricaoRepository
     * @var SequenciaGradesRepository
     * @var SequenciaOperacionalRepository
     * @var RomaneioFooterRepository
     */
    protected $romaneioRepository;
    protected $gradeRepository;
    protected $sequenciaRepository;
    protected $footerRepository;

    public function __construct(
        RomaneioDescricaoRepository     $romaneioDescricaoRepository,
        SequenciaGradesRepository       $SequenciaGradesRepository,
        SequenciaOperacionalRepository  $sequenciaOperacionalRepository,
        RomaneioFooterRepository        $romaneioFooterRepository
    )
    {
        $this->romaneioRepository   = $romaneioDescricaoRepository; 
        $this->gradeRepository      = $SequenciaGradesRepository;  
        $this->sequenciaRepository  = $sequenciaOperacionalRepository;
        $this->footerRepository     = $romaneioFooterRepository;
    }

    public function checkOp($op)
    {
        $ordem_producao = $this->romaneioRepository->findOneBy(["ordem_producao" => $op]);

        if($ordem_producao !== null || $ordem_producao !== "")
        {
            return $ordem_producao;
        } else {
            return [];
        }
    }

    public function getGrade($op)
    {
        $grade = $this->gradeRepository->findBy(["op" => $op]);

        if($grade !== null || $grade !== "")
        {
            return $grade;
        } else {
            return [];
        }
    }

    public function getSequencia($op)
    {
        $sequencia = $this->sequenciaRepository->findBy(["ordemProducao" => $op]);

        if($sequencia !== null || $sequencia !== "")
        {
            return $sequencia;
        } else {
            return [];
        }
    }

    public function getFooter($op)
    {
        $footer = $this->footerRepository->findOneBy(["ordem_producao" => $op]);

        if($footer !== null || $footer !== "")
        {
            return $footer;
        } else {
            return [];
        }
    }

 }