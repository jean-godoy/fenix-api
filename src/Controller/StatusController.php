<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\StatusService;
use App\Util\Traits\ResponseTrait;


/**
 * @Route("/api", name="api_")
 */
class StatusController extends AbstractController
{
    use ResponseTrait;
    private $statusService;

    public function __construct(
        StatusService $statusService
    )
    {
        $this->statusService = $statusService;
    }

    /**
     * @Route("/status", name="status", methods={"GET"})
     */
    public function status(): Response
    {
        $response = $this->statusService->show();

        return $this->json($response, 200, [], []);
    }

    /**
     * @Route("/status", name="insert", methods={"POST"})
     */
    public function insert() : Response
    {   
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $sequencia = $data['sequencia'] ?? null;
        if ($sequencia === null || $sequencia === "")
        {
            return $this->responseNotOK("Campo obrigatório, sequencia", false);
        }

        $status = $data['status'] ?? null;
        if($status === null || $status === "")
        {
            return $this->responseNotOK("Campo obrigatório, status", false);
        }

        $response = $this->statusService->save($sequencia, $status);

        return $this->json($response,200, [], []);
    }
}
