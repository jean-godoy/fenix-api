<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Users;

/**
 * @Route("/users", name="user_")
 */

class UserController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(Users::class)->findAll();

        return $this->json(
            $users
        );
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $json = file_get_contents('php://input');
        $data= json_decode($json, true);

        $user = new Users();
        $user->setUserName($data['user_name']);
        $user->setUserEmail(($data['user_email']));
        $user->setUserPass($data['user_pass']);
        $user->setToken('12345abc');
        $user->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $user->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($user);
        $doctrine->flush();

        // var_dump($data);

        return $this->json([
            'data' => 'Usuario Criado com sucesso referente ao id: '.$user->getId()
        ]);
    }

    /**
     * @Route("/get-id/{id}", name="show", methods={"GET"})
     */
    public function show($id)
    {
        $user = $this->getDoctrine()->getRepository(Users::class)->find($id);

        return $this->json(
            $user
        );
    }

    /**
     * @Route("/update/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update($id)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $doctrine = $this->getDoctrine();

        //busca usuario pelo id
        $user = $doctrine->getRepository(Users::class)->find($id);

        $user->setUserName($data['user_name']);
        $user->setUserEmail($data['user_email']);
        $user->setUserpass($data['user_pass']);
        $user->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $maneger = $doctrine->getManager();
        $maneger->flush();

        return $this->json([
            'data' => 'Usuario atualizado com sucesso!'
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(Users::class)->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($user);
        $manager->flush();

        return $this->json([
            'data' => 'Usuario deletado com sucesso!'
        ]);
    }
}
