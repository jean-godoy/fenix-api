<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\UsersRepository;
use App\Repository\FaccoesRepository;
use App\Repository\PayrollRepository;
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
    protected $payrollRepository;
    private   $em;
    

    public function __construct(
        UsersRepository         $userRepository,
        FaccoesRepository       $faccaoRepository,
        EntityManagerInterface  $entityManagerInterface,
        PayrollRepository       $payrollRepository
    )
    {
        $this->usersRepository      = $userRepository;
        $this->faccaoRepository     = $faccaoRepository;
        $this->em                   = $entityManagerInterface;
        $this->payrollRepository    = $payrollRepository;
    }

    /**
     * @return Response[]
     */
    public function faccaoCode($email)
    {   
        $conn = $this->em->getConnection();
        $faccao_code = null;
        $user_code = $this->usersRepository->findOneBy(["user_email" => $email])->getUserCode();

        $sql = "SELECT * FROM faccoes WHERE user_code = '$user_code'";
        $sql = $conn->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch();
            $faccao_code = $data['faccao_code'];
        }
        
        if($faccao_code == null) {
            return null;
        }

        return $faccao_code;
    }

    /**
     * Faz uma busca no banco por todas payrolls
     * pelo faccao_code
     * 
     * @param string faccao_code
     * @return Response[]
     */
    public function getPayrollData($faccao_code) {

        $result = $this->payrollRepository->findBy(["faccao_code" => $faccao_code]) ?? null;

        if($result === null) {
            return [];
        }

        return $result;
    }



 }