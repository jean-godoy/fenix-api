<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\StatusRepository;
use App\Entity\Status;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class StatusRepository
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class StatusService{

    /**
     * @var StatusRepository
     */
    protected   $statusRepository;
    private     $em;     

    public function __construct(
        StatusRepository        $statusRepository,
        EntityManagerInterface  $entityManagerInterface
    )
    {
        $this->statusRepository = $statusRepository;
        $this->em               = $entityManagerInterface;
    }

    public function save($sequencia, $status)
    {  
       $service = new Status();
       $service->setSequencia(intval($sequencia));
       $service->setStatus($status);

       $this->em->persist($service);
       $this->em->flush();

       return true;
    }

    public function show()
    {
        $response = $this->statusRepository->findAll();

        if($response !== null || $response !== "")
        {
            return $response;
        } else {
            return [];
        }
    }
 }