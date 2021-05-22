<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\FaccaoRomaneioRepository;
use App\Repository\RomaneioDescricaoRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SequenciaOperacionalRepository;
use App\Repository\SequenciaGradesRepository;
use App\Entity\Payroll;
use DateTime;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * Class FaccaoRomaneioService
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

class FaccaoRomaneioService
{

    /**
     * @var FaccaoRomaneioRepository
     * @var RomaneioDescricaoRepository
     * @var SequenciaOperacionalRepository
     */
    protected $faccaoRepository;
    protected $romaneioRepository;
    protected $sequenciaRepository;
    protected $gradeRepository;
    private   $em;

    public function __construct(
        FaccaoRomaneioRepository        $faccaoRomaneioRepository,
        RomaneioDescricaoRepository     $romaneioDescricaoRepository,
        EntityManagerInterface          $entityManagerInterface,
        SequenciaOperacionalRepository  $sequenciaOperacionalRepository,
        SequenciaGradesRepository       $sequenciaGradesRepository
    ) {
        $this->faccaoRepository     = $faccaoRomaneioRepository;
        $this->romaneioRepository   = $romaneioDescricaoRepository;
        $this->em                   = $entityManagerInterface;
        $this->sequenciaRepository  = $sequenciaOperacionalRepository;
        $this->gradeRepository      = $sequenciaGradesRepository;
    }

    /**
     * Retorna uma lista de romaneios pelo
     * facção code
     * @return Response[]
     */
    public function list($faccao_code)
    {
        // $romaenos = $this->faccaoRepository->findBy(["faccao_code" => $faccao_code]) ?? null;
        $conn = $this->em->getConnection();

        $sql = "SELECT * FROM faccao_romaneio AS faccao
                INNER JOIN romaneio_descricao AS romaneio
                ON romaneio.ordem_producao = faccao.ordem_producao
                WHERE faccao.faccao_code = '$faccao_code' 
                AND faccao.faccao_status >= 6
                AND faccao.faccao_status <= 8";

        $sql = $conn->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
            return $response;
        } else {
            return [];
        }
    }

    public function getBy($faccao_code, $op)
    {
        $conn = $this->em->getConnection();

        $sql = "SELECT * FROM faccao_romaneio AS faccao
                INNER JOIN romaneio_descricao AS romaneio
                ON romaneio.ordem_producao = faccao.ordem_producao
                WHERE faccao.faccao_code = '$faccao_code'
                AND faccao.ordem_producao = '$op' ";

        $sql = $conn->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $response = $sql->fetch();
            return $response;
        } else {
            return [];
        }
    }

    public function getSequenciaOp($sequencia)
    {
        $sequencia = json_decode($sequencia, true);
        $response = $this->sequenciaRepository->findBy(["reference_code" => $sequencia]);
        if ($response !== null || $sequencia !== "") {
            return $response;
        } else {
            return [];
        }
    }

    public function getGrade($grade, $op)
    {
        $grade = json_decode($grade, true);
        $response = $this->gradeRepository->findBy(["grade_code" => $grade, "op" => $op]);
        if ($response !== null || $response !== "") {
            return $response;
        } else {
            return [];
        }
    }

    public function setStatus($data)
    {
        $romaneio = $this->faccaoRepository->findOneBy(["romaneio_code" => $data['romaneio_code'], "faccao_code" => $data['faccao_code']]) ?? null;

        if ($romaneio === null || $romaneio == "") {
            return false;
        }

        $status = $data['status'];

        $romaneio->setFaccaoStatus(\intval($status));
        $romaneio->setStatusUpdated(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        /**
         * Caso status seja igual a 7,
         * seta a data de inicio
         */
        if ($data['status'] == 7) {
            $romaneio->setIniciado(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        }

        /**
         * Caso status seja igual a 9,
         * seta data de finalização
         */
        if ($data['status'] == 9) {
            $romaneio->setFinalizado(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
            $pay = $this->createPayroll($data['romaneio_code']);
        }

        $this->em->persist($romaneio);
        $this->em->flush();

        return true;
    }

    public function setPorjecaoColeta(array $data)
    {
        $romaneio = $this->faccaoRepository->findOneBy(["faccao_code" => $data['faccao_code'], "ordem_producao" => $data['ordem_producao']]) ?? null;
        if ($romaneio === null) {
            return false;
        }

        $date_format = new DateTime($data['projecao_coleta']);

        $romaneio->setProjecaoColeta($date_format);
        $this->em->persist($romaneio);
        $this->em->flush();

        return true;
    }

    /**
     * Cria a folha de pagamento assim que o romaneio 
     * é finalizado
     * @param string $romaneio_code
     * 
     * @return []
     */
    private function createPayroll(string $romaneio_code)
    {   
        $data = [];
        $conn = $this->em->getConnection();

        $sql = "SELECT faccao.faccao_code, faccoes.faccao_name, romaneio.referencia AS REF, faccao.ordem_producao as OP, 
                romaneio.descricao_servico, faccao.grade_quantidade AS quantidade, 
                faccao.finalizado, faccao.valor_faccao, faccao.grade_quantidade * faccao.valor_faccao as total
                FROM faccao_romaneio as faccao
                LEFT JOIN romaneio_descricao as romaneio 
                ON romaneio.ordem_producao = faccao.ordem_producao
                LEFT JOIN faccoes
                ON faccao.faccao_code = faccoes.faccao_code
                WHERE faccao.romaneio_code = '$romaneio_code'
                AND romaneio.ordem_producao = faccao.ordem_producao";
        
        $sql = $conn->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
        }

        if($data) {
            $payroll = new Payroll();
            $payroll->setOrdemProducao(intval($data['OP']));
            $payroll->setFaccaoNome($data['faccao_name']);
            $payroll->setRef(intval($data['REF']));
            $payroll->setDescServico($data['descricao_servico']);
            $payroll->setDataEntrega(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
            $payroll->setPreco($data['valor_faccao']);
            $payroll->setQuantidade(intval($data['quantidade']));
            $payroll->setValorTotal($data['total']);
            $payroll->setStatusPagamento(0);
            $payroll->setFaccaoCode($data['faccao_code']);
            $payroll->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
            $payroll->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

            $this->em->persist($payroll);
            $this->em->flush();
        }

        print_r($data); exit;

    }
}
