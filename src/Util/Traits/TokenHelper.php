<?php

declare(strict_types=1);

namespace App\Util\Traits;
use App\Entity\User;
use App\Repository\UserRepository;


class TokenHelper
{
    public static function getUserInfo($tokenData)
    {
        $token = $tokenData->getToken();
        var_dump($token);
        if ($token != null) {
            $user = $token->getUser();

            return $user;
        }
    }

    public static function checkToken(UserRepository $userRepository, $token)
    {
        if ($token != null) {
            $part = explode(".", $token);
            $header = $part[0];
            $payload = $part[1];
            $signature = $part[2];

            $payload = base64_decode($payload);

            $data = json_decode($payload, true);

            if($data != null)
            {   
                $user = $userRepository->findOneBy(["username" => $data["username"]]);
                return $user->getReferenceCode();
            }
   
        }
    }

}
