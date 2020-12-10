<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Faccoes;

/**
 * @Route("/faccoes", name="faccoes_", )
 */
class FaccaoController extends AbstractController
{
    /**
     * @Route("/", name="faccao", methods={"GET"})
     */
    public function index(): Response
    {
        $faccoes = $this->getDoctrine()->getRepository(Faccoes::class)->findAll();

        return $this->json(
            $faccoes
        );
    }

    /**
     * @Route("/get-id/{id}", name="show", methods={"GET"})
     */
    public function show($id)
    {
        $faccao = $this->getDoctrine()->getRepository(Faccoes::class)->find($id);

        return $this->json(
            $faccao
        );
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $faccao = new Faccoes();
        $faccao->setFaccaoName($data['faccao_name']);
        $faccao->setPhone($data['phone']);
        $faccao->setStreet($data['street']);
        $faccao->setCpf($data['cpf']);
        $faccao->setBank($data['bank']);
        $faccao->setEmployees(intval($data['employees']));
        $faccao->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $faccao->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($faccao);
        $doctrine->flush();

        return $this->json([
            'data' => 'Faccao gerado com sucesso!'
        ]);
    }

    /**
     * @Route("/update/{id}", name="update", methods={"PUT", " PATCH"})
     */
    public function update($id)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $doctrine = $this->getDoctrine();

        $faccao = $doctrine->getRepository(Faccoes::class)->find($id);

        $faccao->setFaccaoName($data['faccao_name']);
        $faccao->setPhone($data['phone']);
        $faccao->setStreet($data['street']);
        $faccao->setCpf($data['cpf']);
        $faccao->setBank($data['bank']);
        $faccao->setEmployees($data['employees']);
        $faccao->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'Facção editada com sucesso!'
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        $doctrine = $this->getDoctrine();
        $faccao = $doctrine->getRepository(Faccoes::class)->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($faccao);
        $manager->flush();

        return $this->json([
            'data' => 'Facção deletada com sucesso!'
        ]);
    }
}
