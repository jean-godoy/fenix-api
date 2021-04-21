<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Util\Traits\ResponseTrait;
use App\Service\MobileService;
use App\Service\AuthService;

/**
 * @Route("/mobile", name="mobile_")
 */
class MobileController extends AbstractController
{
    use ResponseTrait;
    private $mobileService;
    private $authService;

    public function __construct(
        MobileService           $mobileService,
        AuthService             $authService
    )
    {
        $this->mobileService    = $mobileService;
        $this->authService      = $authService;
    }

    /**
     * @Route("/credentials", name="credentials", methods={"GET"})
     */
    public function credentials(Request $request): Response
    {
        $token = $request->headers->get('Authorization') ?? null;
        if($token === null || $token === "")
        {
            return $this->responseNotOK("Autorização obrigatoria, token", false);
        }

        $part = explode(" ", $token);
        $token_data = $this->authService->validate($part[1]);
        $user_email = $this->authService->validate($part[1])->user_email;
        
        $faccao_code = $this->mobileService->faccaoCode($user_email);
        
        return $this->json([
            'token_data' => $token_data,
            'faccao_code' => $faccao_code
        ], 200, [], []);
    }
}
