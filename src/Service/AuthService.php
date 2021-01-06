<?php 

declare(strict_types=1);

namespace App\Service;

use App\Repository\UsersRepository;
use DateTime;

/**
 * Class AuthService
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class AuthService
 {
    /**
     * @var UsersRepository
     */

     protected $usersRepository;
     private $userMail;
     private $uid;
     private $jwt_key = 'abc123';
     private $token;
     private $roles;

     public function __construct(
         UsersRepository            $usersRepository
     )
     {
         $this->usersRepository     = $usersRepository;
     }

     public function login($email, $password)
     {
         $login = $this->usersRepository->findOneBy(["user_email" => $email, "user_pass" => $password]);

         if($login === null || $login === "")
         {  
            return [];
         } else {
            $this->userMail = $login->getUserEmail();
            $this->uid      = $login->getId();
            $this->roles    = $login->getRoles();
            $this->jwt();

            return $this->token;
         }
     }

     private function jwt()
     {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256' 
        ];

        $payload = [
            'exp'           => (new DateTime("now"))->getTimestamp(),
            'uid'           => $this->uid,
            'roles'         => $this->roles,
            'user_email'    => $this->userMail
        ];


        //JSON
        $header     = json_encode($header);
        $payload    = json_encode($payload);

        //BASE 64
        $header     = base64_encode($header);
        $payload    = base64_encode($payload);

        // GENERATE SIGN
        $sign = hash_hmac('sha256', $header.".".$payload, $this->jwt_key, true);
        $sign = base64_encode($sign);

        // GENERATE TOKEN
        $this->token = "token: ".$header .".". $payload .".". $sign;

        return $this->token;
     }

     public function validate($token)
     {
         if($token !== null || $token !== "")
         {
             $part          = explode(".", $token);
             $header        = $part[0];
             $payload       = $part[1];
             $signature     = $part[2];

             $valid = hash_hmac('sha256', $header.".".$payload, $this->jwt_key, true);
             $valid = base64_encode($valid);

             if($signature === $valid){
                 $payload = base64_decode($payload);
                 $payload = json_decode($payload);
                 return $payload;
             }else {
                 return false;
             }
         }
     }

 }