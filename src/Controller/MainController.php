<?php

namespace App\Controller;

use Doctrine\DBAL\Schema\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="main_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return $this->render('login/login.html.twig');
    }

    /**
     * @Route("/home", name="home", methods={"GET"})
     */
    public function home(): Response
    {
        return $this->render('main/main.html.twig');
    }
}
