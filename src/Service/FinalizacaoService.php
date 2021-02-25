<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\FaccaoRomaneio;
use App\Repository\FaccaoRomaneioRepository;
use App\Repository\RomaneioDescricaoRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FinalizacaoRomaneioService
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

class FinalizacaoService
{

    /**
     * @var FaccaoRomaneioRepository
     * @var RomaneioDescricaoRepository
     */

    private $em;
    protected $faccaoRepository;
    protected $romaneioRepository;

    public function __construct(
        FaccaoRomaneioRepository    $faccaoRomaneioRepository,
        RomaneioDescricaoRepository $romaneioDescricaoRepository,
        EntityManagerInterface      $entityManagerInterface

    )
    {
        $this->faccaoRepository     = $faccaoRomaneioRepository;
        $this->romaneioRepository   = $romaneioDescricaoRepository;
        $this->em                   = $entityManagerInterface;
    }

     /**
     * @return []
     */
    public function getAll()
    {
        // $result = $this->faccaoRepository->findBy(["faccao_status" => 11]) ?? null;
        $conn = $this->em->getConnection();

        $sql = "SELECT * FROM faccao_romaneio WHERE faccao_status >= 11 AND faccao_status <= 15";
        $sql = $conn->prepare($sql);
        $sql->execute();

        
        if($sql->rowCount() > 0)
        {
            $response = $sql->fetchAll();
            return $response;
        }

        return false;
    }

    /**
     * @return []
     */
    public function getBy($faccao_code, $op)
    {
        $result = $this->faccaoRepository->findOneBy(["faccao_code" => $faccao_code, "ordem_producao" => $op]) ?? null;

        if($result !== null || $result !== "")
        {
            return $result;
        } else {
            return null;
        }

    }


}
