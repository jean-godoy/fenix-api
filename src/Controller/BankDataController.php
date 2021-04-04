<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BankDataController extends AbstractController
{
    /**
     * @Route("/bank/data", name="bank_data")
     */
    public function index(): Response
    {
        return $this->render('bank_data/index.html.twig', [
            'controller_name' => 'BankDataController',
        ]);
    }
}
