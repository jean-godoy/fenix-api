<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\UsersRepository;
use App\Repository\FaccoesRepository;
use Doctrine\ORM\EntityManagerInterface;

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
    private   $em;
    

    public function __construct(
        UsersRepository         $userRepository,
        FaccoesRepository       $faccaoRepository,
        EntityManagerInterface  $entityManagerInterface
    )
    {
        $this->usersRepository  = $userRepository;
        $this->faccaoRepository = $faccaoRepository;
        $this->em               = $entityManagerInterface;
    }

    /**
     * @return Response[]
     */
    public function faccaoCode($email)
    {   
        $conn = $this->em->getConnection();

        $user_code = $this->usersRepository->findOneBy(["user_email" => $email])->getUserCode();

        $sql = "SELECT * FROM faccoes WHERE user_code = '$user_code'";
        $sql = $conn->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch();
            $faccao_code = $data['faccao_code'];
        }
        
        if($faccao_code == NULL) {
            return null;
        }

        return $faccao_code;
    }

 }