<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @Route("/auth", name="auth_")
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/auth", name="auth")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }

    /**
     * @Route("/checked", name="checked", methods={"POST"})
     */
    public function checked(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // $users = $this->getDoctrine()->getRepository(Users::class)->findBy(['user_email' => $data['user_email']]);

        $sql = "SELECT * FROM users WHERE user_name = :user_name AND user_pass = :user_pass";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_name', $data['user_name']);
        $stmt->bindValue(':user_pass', $data['user_pass']);

        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            $user = $stmt->fetch();
        }

        // if(count($users) > 0){
        //     throw new BadRequestHttpException('User not found', null, 404);
        // }

        return $this->json(
            $user
        );
    }
}
