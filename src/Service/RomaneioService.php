<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\MoneyService;

use App\Repository\RomaneioDescricaoRepository;
use App\Repository\SequenciaOperacionalRepository;
use App\Repository\SequenciaGradesRepository;
use App\Repository\RomaneioFooterRepository;
use App\Repository\FaccaoRomaneioRepository;
use App\Repository\PayrollRepository;

use App\Entity\FaccaoRomaneio;
use App\Entity\SequenciaOperacional;
use Exception;
use PhpParser\Node\Stmt\Foreach_;

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
    protected $payrollRepository;

    public function __construct(
        RomaneioDescricaoRepository     $romaneioDescricaoRepository,
        EntityManagerInterface          $em,
        SequenciaGradesRepository       $sequenciaGradesRepository,
        MoneyService                    $moneyService,
        SequenciaOperacionalRepository  $sequenciaOperacionalRepository,
        PayrollRepository               $payrollRepository
    ) {
        $this->romaneioRepository       = $romaneioDescricaoRepository;
        $this->em                       = $em;
        $this->gradeRepository          = $sequenciaGradesRepository;
        $this->money                    = $moneyService;
        $this->sequenciaOperacional     = $sequenciaOperacionalRepository;
        $this->payrollRepository        = $payrollRepository;
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

        //seta todas grades selecionadas
        foreach ($array['grade'] as $key => $value) {
            $sql = "UPDATE sequencia_grades SET checked = true WHERE grade_code = '{$value}'";
            $sql = $conn->prepare($sql);
            $sql->execute();
        }

        //seta todas sequencias operacionais selecionadas
        foreach ($array['sequencia'] as $key => $value) {
            $sql = "UPDATE sequencia_operacional SET checked = true WHERE reference_code = '{$value}'";
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
        $res = $this->payrollRepository->findBy(["nfe" => $nfe]);
        // $conn = $this->em->getConnection();

        // $sql = "SELECT * FROM romaneio_descricao AS romaneio
        //         LEFT JOIN faccao_romaneio AS faccao
        //         ON romaneio.ordem_producao = faccao.ordem_producao
        //         LEFT JOIN faccoes
        //         ON faccao.faccao_code = faccoes.faccao_code
        //         WHERE romaneio.num_nfe = $nfe
        //         AND faccao.faccao_status >= 11
        //     ";

        // $sql = $conn->prepare($sql);
        // $sql->execute();

        // if ($sql->rowCount() > 0) {
        //     $response = $sql->fetchAll();
        //     return $response;
        // } else {
        //     return [];
        // }

        return $res;
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

    /**
     * Deleta tudo referente ao romaneio
     * @param ordem_producao
     * @return Response[]
     */
    public function delete($ordem_producao)
    {
        try {
            $conn = $this->em->getConnection();

            $sql = "DELETE FROM romaneio_descricao WHERE ordem_producao = $ordem_producao";
            $sql = $conn->prepare($sql);
            $sql->execute();

            $sql = "DELETE FROM romaneio_footer WHERE ordem_producao = $ordem_producao";
            $sql = $conn->prepare($sql);
            $sql->execute();

            $sql = "DELETE FROM sequencia_operacional WHERE ordem_producao = $ordem_producao";
            $sql = $conn->prepare($sql);
            $sql->execute();

            $sql = "DELETE FROM faccao_romaneio WHERE ordem_producao = $ordem_producao";
            $sql = $conn->prepare($sql);
            $sql->execute();

            $sql = "DELETE FROM sequencia_grades WHERE op = $ordem_producao";
            $sql = $conn->prepare($sql);
            $sql->execute();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
