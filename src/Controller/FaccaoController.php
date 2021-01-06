<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Faccoes;
use App\Entity\Users;

use App\Util\Traits\ResponseTrait;

/**
 * @Route("/faccoes", name="faccoes_", )
 */
class FaccaoController extends AbstractController
{

    use ResponseTrait;
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
        $user_code = md5(uniqid(rand() . "", true));
        $faccao_code = md5(uniqid(rand() . "", true));
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if($data === null || $data === "")
        {
            return $this->responseNotOK("Obrigatorio preencher todos os campos", false);
        }

        $doctrine = $this->getDoctrine()->getManager();

        $user = new Users();
        $user->setUserName($data['user_name']);
        $user->setUserEmail($data['user_email']);
        $user->setUserPass($data['user_pass']);
        $user->setRoles(3);
        $user->setUserCode($user_code);
        $user->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $user->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine->persist($user);
        $doctrine->flush();

        $faccao = new Faccoes();
        $faccao->setFaccaoName($data['faccao_name']);
        $faccao->setPhone($data['phone']);
        $faccao->setStreet($data['street']);
        $faccao->setCpf($data['cpf']);
        $faccao->setBank($data['bank']);
        $faccao->setEmployees(intval($data['employees']));
        $faccao->setUserCode($user_code);
        $faccao->setFaccaoCode($faccao_code);
        $faccao->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $faccao->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

    
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
