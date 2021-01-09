<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\CheckingRepository;

/**
 * Class CheckingService
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class CheckingService{

    /**
     * @var CheckingRepository
     */

     protected $checkingRepository;

     public function __construct(CheckingRepository $checkingRepository)
     {
         $this->checkingRepository = $checkingRepository;
     }

     public function checkNfe($nfe_number)
     {
        $response = $this->checkingRepository->findOneBy(["nfe_number" => $nfe_number]);

        if($response === null || $response === ""){
            return true;
        } else {
            return false;
        }
     }
 }