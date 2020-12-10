<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Grade;

/**
 * @Route("/test", name="test_")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/all", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $grade = $this->getDoctrine()->getRepository(Grade::class)->findAll();

        return $this->json($grade);
    }
}
