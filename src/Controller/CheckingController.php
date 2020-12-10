<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Checking;

/**
 * @Route("/checking", name="checking_")
 */
class CheckingController extends AbstractController
{
    /**
     * @Route("/", name="")
     */
    public function index(): Response
    {
        $check = $this->getDoctrine()->getRepository(Checking::class)->findAll();

        return $this->json(
            $check
        );
    }

    /**
     * @Route("/get-id/{id}", name="show", methods={"GET"})
     */
    public function show($id)
    {
        $check = $this->getDoctrine()->getRepository(Checking::class)->find($id);
        return $this->json(
            $check
        );
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $check = new Checking();
        $check->setOs($data['os']);
        $check->setStatus($data['status']);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($check);
        $doctrine->flush();

        return $this->json([
            'data' => 'Ordem de Serviço cadastrada com sucesso!'
        ]);
    }

    /**
     * @Route("/update/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update($id)
    {
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $doctrine = $this->getDoctrine();

        $check = $doctrine->getRepository(Checking::class)->find($id);

        $check->setOs($data['os']);
        $check->setStatus($data['status']);

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'O.P. alterada com sucesso!'
        ]);
    }

    /**
     * @Route("/status/{id}", name="status", methods={"PUT", "PATCH"})
     */
    public function status($id)
    {
       
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $doctrine = $this->getDoctrine();

        $check = $doctrine->getRepository(Checking::class)->find($id);

        $check->setStatus($data['status']);

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'Status Alterado com sucesso!'
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        $doctrine = $this->getDoctrine();
        $check = $doctrine->getRepository(Checking::class)->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($check);
        $manager->flush();

        return $this->json([
            'data' => 'O.S. apagada com sucesso!'
        ]);
    }
}
