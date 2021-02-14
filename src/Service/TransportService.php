<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\FaccaoRomaneioRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TransportService
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class TransportService {

    private $em;
    private $faccaoRomaneioRepository;

    public function __construct(
        FaccaoRomaneioRepository $faccaoRomaneioRepository,
        EntityManagerInterface   $entityManagerInterface
    )
    {
        $this->faccaoRomaneioRepository = $faccaoRomaneioRepository;
        $this->em                       = $entityManagerInterface;
    }

    public function show()
    {
        $response = $this->faccaoRomaneioRepository->findBy(["faccao_status" => 9]) ?? null;
        if($response !== null || $response !== "")
        {
            return $response;
        } else {
            return null;
        }
    }

    public function getRomaneio($faccao_code, $op)
    {
        $conn = $this->em->getConnection();

        $sql = "SELECT * FROM faccao_romaneio as romaneio
                LEFT JOIN faccoes 
                ON romaneio.faccao_code = faccoes.faccao_code
                WHERE romaneio.faccao_code = '$faccao_code'
                AND romaneio.ordem_producao = '$op' 
            ";

        $sql = $conn->prepare($sql);
        $sql->execute();    

        if($sql->rowCount() > 0)
        {   
            $response = $sql->fetch();
            return $response;
        } else {
            return false;
        }
    }
 }