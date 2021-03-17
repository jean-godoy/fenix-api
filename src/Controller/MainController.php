<?php

namespace App\Controller;

use Doctrine\DBAL\Schema\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\SessionService;

/**
 * @Route("/", name="main_")
 */
class MainController extends AbstractController
{
    private $session;

    public function __construct(
        SessionService  $sessionService            
    ) {
        $this->session      = $sessionService;
    }

    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $checkSession = $this->session->getSession();
        if($checkSession) {
            return $this->render('main/main.html.twig');
        }

        return $this->render('login/login.html.twig');
    }
}
