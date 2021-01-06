<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Util\Traits\ResponseTrait;
use App\Service\AuthService;

/**
 * @Route("/auth", name="auth_")
 */
class AuthController extends AbstractController
{
    use ResponseTrait;
    private $authService;

    public function __construct(
        AuthService      $authService
    ) {
        $this->authService  = $authService;
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

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
        }

        // if(count($users) > 0){
        //     throw new BadRequestHttpException('User not found', null, 404);
        // }

        return $this->json(
            $user
        );
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login()
    {
        $context['ignored_attributes'] = ['createdAt', 'deletedAt', 'updatedAt'];
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $email = $data['user_email'] ?? null;
        if($email === null || $email === ""){
            return $this->responseNotOK("Campo obrigatorio: "."login", false);
        }
        $password = $data['user_pass'] ?? null;
        if($password == null || $password === ""){
            return $this->responseNotOK("Campo obrigatorio: "."password", false);
        }

        $response = $this->authService->login($email, $password);

        if($response === null || $response === ""){
            return $this->responseNotOK("Usuario ou Senha não correspondem!", false);
        }

        return $this->json($response, 200, [], $context);
    }

    /**
     * @Route("/login-faccao", name="loginFaccao", methods={"POST"})
     */
    public function loginFaccao()
    {
        $context['ignored_attributes'] = ['createdAt', 'deletedAt', 'updatedAt'];
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        $email = $data['user_email'] ?? null;
        if($email === null || $email === ""){
            return $this->responseNotOK("Campo obrigatorio: "."email", false);
        }
        $password = $data['user_pass'] ?? null;
        if($password == null || $password === ""){
            return $this->responseNotOK("Campo obrigatorio: "."password", false);
        }

        $response = $this->authService->login($email, $password);

        if($response === null || $response === ""){
            return $this->responseNotOK("Usuario ou Senha não correspondem!", false);
        }

        return $this->json($response, 200, [], $context);
    }

    /**
     * @Route("/validate", name="validate", methods={"POST"})
     */
    public function validate(Request $request)
    {
        $context['ignored_attributes'] = ['createdAt', 'deletedAt', 'updatedAt'];
        $token = $request->headers->get('Authorization');
        $part = explode(" ", $token);
        $response = $this->authService->validate($part[1]);
        
        return $this->json($response, 200, [], $context);
    }
}
