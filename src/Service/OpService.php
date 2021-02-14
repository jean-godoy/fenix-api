<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\CheckingRepository;

/**
 * Class OpService
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class OpService{

    /**
     * @var CheckingRepository
     */
    protected $checkingRepository;

    public function __construct(CheckingRepository $checkingRepository)
    {
        $this->checkingRepository = $checkingRepository;
    }

    public function getNfeNumber()
    {
        $reponse = $this->checkingRepository->findBy(["status" => 5]);

        if($reponse !== null || $reponse !== ""){
            return $reponse;
        }else {
            return [];
        }
    }
 }