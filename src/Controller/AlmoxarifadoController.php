<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Almoxarifados;

/**
 * @Route("/almoxarifados", name="almoxarifdos_")
 */

class AlmoxarifadoController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $almoxarifados = $this->getDoctrine()->getRepository(Almoxarifados::class)->findAll();
        
        return $this->json(
            $almoxarifados
        );
    }

    /**
     * @Route("/get-id/{id}", name="show", methods={"GET"})
     */
    public function show($id)
    {
        $almoxarifado = $this->getDoctrine()->getRepository(Almoxarifados::class)->find($id);

        return$this->json(
            $almoxarifado
        );
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $almoxarifado = new Almoxarifados();
        $almoxarifado->setProduto($data['produto']);
        $almoxarifado->setMarca($data['marca']);
        $almoxarifado->setModelo($data['modelo']);
        $almoxarifado->setNumSerie($data['num_serie']);
        $almoxarifado->setQuantidade($data['quantidade']);
        $almoxarifado->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $almoxarifado->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($almoxarifado);
        $doctrine->flush();

        return $this->json([
            'data'=> 'Produto: '.$data['produto'].', Cadastrado com sucesso'
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

        //get user by id
        $almoxarifado = $doctrine->getRepository(Almoxarifados::class)->find($id);

        $almoxarifado->setProduto($data['produto']);
        $almoxarifado->setMarca($data['marca']);
        $almoxarifado->setModelo($data['modelo']);
        $almoxarifado->setNumSerie($data['num_serie']);
        $almoxarifado->setQuantidade($data['quantidade']);
        $almoxarifado->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'Produto atualizado com sucesso!'
        ]); 
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        $doctrine = $this->getDoctrine();

        $almoxarifado = $doctrine->getRepository(Almoxarifados::class)->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($almoxarifado);
        $manager->flush();

        return $this->json([
            'data' => 'Produto deletedo com sucesso!'
        ]);
    }
}
