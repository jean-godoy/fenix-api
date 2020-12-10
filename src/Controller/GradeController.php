<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Grade;
use App\Entity\GradeRomaneio;

/**
 * @Route("/grade", name="grade_")
 */
class GradeController extends AbstractController
{
    /**
     * @Route("/all", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $grade = $this->getDoctrine()->getRepository(Grade::class)->findAll();

        return $this->json($grade);
    }

    /**
     * @Route("/get-id/{id}", name="show", methods={"GET"})
     */
    public function show($id)
    {
        $grade = $this->getDoctrine()->getRepository(Grade::class)->find($id);

        return $this->json($grade);
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $grade = new Grade();
        $grade->setGrade($data['grade']);
        $grade->setTamanho($data['tamanho']);
        $grade->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $grade->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($grade);
        $doctrine->flush();

        return $this->json([
            'data' => 'Grade adicionada com sucesso'
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

        //get grade by id
        $grade = $doctrine->getRepository(Grade::class)->find($id);

        $grade->setGrade($data['grade']);
        $grade->setTamanho($data['tamanho']);
        $grade->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'Grade atualizada com sucesso!'
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        $doctrine = $this->getDoctrine();

        $grade = $doctrine->getRepository(Grade::class)->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($grade);
        $manager->flush();

        return $this->json([
            'grade' => 'Grade removida com sucesso!'
        ]);
    }

    /**
     * @Route("/grade-romaneio-add", name="gradeRomaneioAdd", methods={"POST"})
     */
    public function gradeRomaneioAdd()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $grade = new GradeRomaneio();
        $grade->setOp($data['op']);
        $grade->setGrade($data['grade']);
        $grade->setQuantidade($data['quantidade']);
        $grade->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $grade->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($grade);
        $doctrine->flush();

        return $this->json([
            'data' => 'Grade cadastrada com sucesso!'
        ]);
    }
}
