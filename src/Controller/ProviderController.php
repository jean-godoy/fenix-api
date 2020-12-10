<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Providers;

/**
 * @Route("/providers", name="provider_")
 */
class ProviderController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $providers = $this->getDoctrine()->getRepository(Providers::class)->findAll();
        return $this->json(
            $providers
        );
    }

    /**
     * @Route("/get-id/{id}", name="show", methods={"GET"})
     */
    public function show($id)
    {
        $provider = $this->getDoctrine()->getRepository(Providers::class)->find($id);

        return $this->json(
            $provider
        );
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $json = file_get_contents('php://input');
        $data= json_decode($json, true);

        $provider = new Providers();
        $provider->setProviderName($data['provider_name']);
        $provider->setCnpj($data['cnpj']);
        $provider->setStreet($data['street']);
        $provider->setDistrict($data['district']);
        $provider->setCep($data['cep']);
        $provider->setCity($data['city']);
        $provider->setPhone($data['phone']);
        $provider->setUf($data['uf']);
        $provider->setSubscription($data['subscription']);
        $provider->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $provider->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($provider);
        $doctrine->flush();

        return $this->json([
            'data' => 'Fornecedor cadastrado com sucesso!'
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

        $provider = $doctrine->getRepository(Providers::class)->find($id);

        $provider->setProviderName($data['provider_name']);
        $provider->setCnpj($data['cnpj']);
        $provider->setStreet($data['street']);
        $provider->setDistrict($data['district']);
        $provider->setCep($data['cep']);
        $provider->setCity($data['city']);
        $provider->setPhone($data['phone']);
        $provider->setUf($data['uf']);
        $provider->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'Fornecedor atualizado com sucesso!'
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        $doctrine = $this->getDoctrine();

        $provider = $doctrine->getRepository(Providers::class)->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($provider);
        $manager->flush();

        return $this->json([
            'data' => 'Fornecedor deletado com sucesso!'
        ]);
    }
}
