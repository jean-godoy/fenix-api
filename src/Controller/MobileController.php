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
    ) {
        $this->mobileService    = $mobileService;
        $this->authService      = $authService;
    }

    /**
     * @Route("/credentials", name="credentials", methods={"GET"})
     */
    public function credentials(Request $request): Response
    {
        $token = $request->headers->get('Authorization') ?? null;
        if ($token === null || $token === "") {
            return $this->responseNotOK("Autorização obrigatoria, token", false);
        }

        $part = explode(" ", $token);
        $tkn = $part[1];
        $token_data = $this->authService->validate($tkn) ?? null;

        $user_email = $this->authService->validate($part[1])->user_email;

        $faccao_code = $this->mobileService->faccaoCode($user_email) ?? null;

        if ($faccao_code === null) {
            $faccao_code = "inDrive";
        }

        return $this->json([
            'token_data' => $token_data,
            'faccao_code' => $faccao_code
        ], 200, [], []);
    }

    /**
     * Metodo que retorna um array de pagamentos
     * 
     * @Route("/get-payroll/{faccao_code}", name="getPayroll", methods={"GET"})
     * @param string $faccao_code
     * @return array $payroll
     */
    public function getPayRoll($faccao_code): Response
    {
        if($faccao_code === null || $faccao_code === "") {
            return $this->responseNotOK("Campo obrigatório, faccao_code", false);
        }

        $payroll = $this->mobileService->getPayRollData($faccao_code);

        return $this->json($payroll, 200, [], []);
    }
}
