<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\BankDataRepository;
use App\Entity\BankData;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BankDataService
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

class BankDataService
{

    private $bankDataRepo;
    private $em;

    public function __construct(
        BankDataRepository      $bankDataRepository,
        EntityManagerInterface  $entityManagerInterface
    ) {
        $this->bankDataRepo = $bankDataRepository;
        $this->em           = $entityManagerInterface;
    }

    /**
     * @return []
     */
    public function show($faccao_code)
    {
        $response = $this->bankDataRepo->findOneBy(["faccao_code" => $faccao_code]) ?? null;

        if ($response === null) {
            return false;
        }

        return $response;
    }

    public function generate(array $data)
    {
        // try {
            $bankData = new BankData();
            $bankData->setFaccaoCode($data['faccao_code']);
            $bankData->setNomeTitular($data['nome_titular']);
            $bankData->setCpfTitular(intval($data['cpf_titular']));
            $bankData->setBanco($data['banco']);
            $bankData->setAgencia($data['agencia']);
            $bankData->setConta($data['conta']);
            $bankData->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
            $bankData->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

            $this->em->persist($bankData);
            $this->em->flush();

            return true;
        // } catch (\Exception $e) {
        //     echo "Exceção capturada: $e->getMessage() ";
        //     return false;
        // }
    }
}
