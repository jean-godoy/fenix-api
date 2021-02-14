<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\RomaneioDescricaoRepository;
use App\Entity\FaccaoRomaneio;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SequenciaGradesRepository;

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

    public function __construct(
        RomaneioDescricaoRepository $romaneioDescricaoRepository,
        EntityManagerInterface      $em,
        SequenciaGradesRepository   $sequenciaGradesRepository
    ) {
        $this->romaneioRepository = $romaneioDescricaoRepository;
        $this->em                 = $em;
        $this->gradeRepository    = $sequenciaGradesRepository;
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
     * @return Response[]
     */
    public function save($array)
    {
        $data_now = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));

        $romaneio = new FaccaoRomaneio;
        $romaneio->setFaccaoCode($array["faccao_code"]["value"]);
        $romaneio->setOrdemProducao($array["ordem_producao"]);
        $romaneio->setGrade(json_encode($array['grade']));
        $romaneio->setSeguencia(json_encode($array['sequencia']));
        $romaneio->setRomaneioCode(md5(uniqid(rand() . "", true)));
        $romaneio->setCreatedAt($data_now);
        $romaneio->setUpdatedAt($data_now);
        $romaneio->setFaccaoStatus(6);

        $this->em->persist($romaneio);
        $this->em->flush();

        // $grade = $this->gradeRepository->findBy(["grade_code" => $array['grade']]);

        return true;
    }

    /**
     * @return Response[]
     */
    public function list()
    {
        $conn = $this->em->getConnection();
        $sql = "SELECT * FROM faccao_romaneio AS faccao
                RIGHT JOIN romaneio_descricao AS romaneio
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
}
