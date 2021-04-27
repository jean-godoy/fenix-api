<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\RomaneioDescricaoRepository;
use App\Entity\FaccaoRomaneio;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SequenciaGradesRepository;
use App\Service\MoneyService;
use App\Entity\SequenciaOperacional;
use App\Repository\SequenciaOperacionalRepository;

/**
 * Class RomaneioDescricao
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

class RomaneioService
{
    /**
     * @var RomaneioDescricaoRepository
     * @var SequenciaGradesRepository
     */

    protected $romaneioRepository;
    protected $gradeRepository;
    private $em;
    private $money;
    private $sequenciaOperacional;

    public function __construct(
        RomaneioDescricaoRepository     $romaneioDescricaoRepository,
        EntityManagerInterface          $em,
        SequenciaGradesRepository       $sequenciaGradesRepository,
        MoneyService                    $moneyService,
        SequenciaOperacionalRepository  $sequenciaOperacionalRepository
    ) {
        $this->romaneioRepository       = $romaneioDescricaoRepository;
        $this->em                       = $em;
        $this->gradeRepository          = $sequenciaGradesRepository;
        $this->money                    = $moneyService;
        $this->sequenciaOperacional     = $sequenciaOperacionalRepository;
    }

    /**
     * @return Response[]
     */
    public function getRomaneio($op)
    {
        $romaneio = $this->romaneioRepository->findOneBy(["ordem_producao" => $op]);

        if ($romaneio !== null || $romaneio !== "") {
            return $romaneio;
        } else {
            return [];
        }
    }

    /**
     * Salva os dados do faccao_romaneio
     * @return Response[]
     */
    public function save($array, $doctrine)
    {
        $data_now = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
        $romaneio = new FaccaoRomaneio;

        $romaneio->setFaccaoCode($array["faccao_code"]);
        $romaneio->setOrdemProducao($array["ordem_producao"]);
        $romaneio->setGrade(json_encode($array['grade']));
        $romaneio->setSeguencia(json_encode($array['sequencia']));
        $romaneio->setRomaneioCode(md5(uniqid(rand() . "", true)));
        $romaneio->setCreatedAt($data_now);
        $romaneio->setUpdatedAt($data_now);
        $romaneio->setFaccaoStatus(6);
        $romaneio->setValorFaccao($this->money->toUsd($array['valor_faccao']));
        $romaneio->setGradeQuantidade(\strval($array['grade_quantidade']));
        $romaneio->setPrevisaoEntrega(new \DateTime($array['previsao_entrega'], new \DateTimeZone('America/Sao_Paulo')));

        $this->em->persist($romaneio);
        $this->em->flush();

        $conn = $this->em->getConnection();

        for ($i = 1; $i <= count($array['sequencia']); $i++) {

            $sql = "UPDATE sequencia_operacional SET checked = false WHERE reference_code = '{$array['sequencia'][$i]}'";
            $sql = $conn->prepare($sql);
            $sql->execute();
        }


        return true;
    }

    /**
     * @return Response[]
     */
    public function list()
    {
        $conn = $this->em->getConnection();
        $sql = "SELECT * FROM faccao_romaneio AS faccao
                JOIN romaneio_descricao AS romaneio
                On romaneio.ordem_producao = faccao.ordem_producao
                RIGHT JOIN faccoes 
                ON faccoes.faccao_code = faccao.faccao_code
            ";

        $sql = $conn->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
            return $response;
        } else {
            return [];
        }
    }

    /**
     * @return Response[]
     */
    public function getRomaneioByNfe($nfe)
    {
        $conn = $this->em->getConnection();

        $sql = "SELECT * FROM romaneio_descricao AS romaneio
                LEFT JOIN faccao_romaneio AS faccao
                ON romaneio.ordem_producao = faccao.ordem_producao
                LEFT JOIN faccoes
                ON faccao.faccao_code = faccoes.faccao_code
                WHERE romaneio.num_nfe = $nfe
            ";

        $sql = $conn->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
            return $response;
        } else {
            return [];
        }
    }

    /**
     * @return Response[]
     */
    public function getFinanceiroRomaneioByNfe($nfe)
    {
        $conn = $this->em->getConnection();

        $sql = "SELECT * FROM romaneio_descricao AS romaneio
                LEFT JOIN faccao_romaneio AS faccao
                ON romaneio.ordem_producao = faccao.ordem_producao
                LEFT JOIN faccoes
                ON faccao.faccao_code = faccoes.faccao_code
                WHERE romaneio.num_nfe = $nfe
                AND faccao.faccao_status >= 11
            ";

        $sql = $conn->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
            return $response;
        } else {
            return [];
        }
    }

    /**
     * @return Response[]
     */
    public function nfeList()
    {
        $conn =  $this->em->getConnection();
        $sql = "SELECT id, nfe_number, status FROM checking WHERE status = 5 ";

        $sql = $conn->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
            return $response;
        }

        return [];
    }
}
