<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Checking;
use App\Entity\GradeRomaneio;
use App\Entity\Faccoes;

/**
 * @Route("/romaneios", name="romaneio_")
 */
class RomaneioController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();

        $sql = "SELECT * FROM checking WHERE status = 2";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            $romaneio = $stmt->fetchAll();
        }else {
            $romaneio = "Nenhum Romaneio Cadastrado";
        }

        return $this->json(
           $romaneio
        );
    }

    /**
     * @Route("/get-op", name="getOp", methods={"GET"})
     */
    public function getOp()
    {
        $romaneio = $this->getDoctrine()->getRepository(GradeRomaneio::class)->findAll();

        return $this->json($romaneio);
    }

    /**
     * @Route("/expedicao/{op}", name="romaneioExpedicao", methods={"GET"})
     */
    public function romaneioExpedicao($op)
    {
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();

        $sql = "SELECT * FROM grade_romaneio WHERE op = $op";
        $sql = $conn->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0)
        {
            $romaneio = $sql->fetchAll();
        }else {
            $romaneio = "Nenhum Romaneio Corresponde a essa OP!";
        }

        return $this->json($romaneio);
    }

    /**
     * @Route("/get-faccoes", name="getFaccaoes", methods={"GET"})
     */
    public function getFaccoes()
    {
        $faccoes = $this->getDoctrine()->getRepository(Faccoes::class)->findAll();

        return $this->json($faccoes);
    }
}
