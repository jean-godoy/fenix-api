<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\UsersRepository;
use App\Repository\FaccoesRepository;

/**
 * Class MobileRepository
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class MobileService
 {
    /**
    * @var UserRepository
    * @var FaccoesRepository
    */
    protected $usersRepository;
    protected $faccaoRepository;

    public function __construct(
        UsersRepository     $userRepository,
        FaccoesRepository   $faccaoRepository
    )
    {
        $this->usersRepository  = $userRepository;
        $this->faccaoRepository = $faccaoRepository;
    }

    /**
     * @return Response[]
     */
    public function faccaoCode($email)
    {
        $user_code = $this->usersRepository->findOneBy(["user_email" => $email])->getUserCode();
        
        $faccao_code = $this->faccaoRepository->findOneBy(["user_code" => $user_code]);
        
        if($faccao_code == NULL) {
            return null;
        }

        return $faccao_code;
    }

 }