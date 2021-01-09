<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Checking;
use App\Util\Traits\ResponseTrait;
use App\Service\CheckingService;

/**
 * @Route("/checking", name="checking_")
 */
class CheckingController extends AbstractController
{

    use ResponseTrait;
    private $checkingService;

    public function __construct(CheckingService $checkingService)
    {
        $this->checkingService = $checkingService;
    }

    /**
     * @Route("/", name="")
     */
    public function index(): Response
    {
        $check = $this->getDoctrine()->getRepository(Checking::class)->findAll();

        return $this->json(
            $check
        );
    }

    /**
     * @Route("/get-id/{id}", name="show", methods={"GET"})
     */
    public function show($id)
    {
        $check = $this->getDoctrine()->getRepository(Checking::class)->find($id);
        return $this->json(
            $check
        );
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $data_now = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));

        $nfe_file = $_FILES['nfe_file']['tmp_name'];

        if ($nfe_file === null || $nfe_file === "") {
            return $this->responseNotOK("Campo Obrigatorio, nfe_file", false);
        }

        $nfe_file = simplexml_load_string(file_get_contents($nfe_file));
        $json   = json_encode($nfe_file);
        $array  = json_decode($json, TRUE);

        $nfe_key    = $array["NFe"]["infNFe"]["@attributes"]["Id"];
        if ($nfe_key === null || $nfe_key === "") {
            return $this->responseNotOK("Problemas ao extrair nfe_key", false);
        }
        $parts      = explode("e", $nfe_key);
        $nfe_key    = intval($parts[1]);

        $nfe_number = $array["NFe"]["infNFe"]["ide"]["nNF"];
        if ($nfe_number === null || $nfe_number === "") {
            return $this->responseNotOK("Problemas ao extrair nfe_number", false);
        }

        $cheched = $this->checkingService->checkNfe($nfe_number);

        if($cheched === true) {
            $check = new Checking();
            $check->setNfeKey($nfe_key);
            $check->setNfeNumber($nfe_number);
            $check->setCreatedAt($data_now);
            $check->setUpdatedAt($data_now);
            $check->setStatus(1);

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($check);
            $doctrine->flush();

            return $this->json([
                'data' => 'Dados do arquivo NF-e salvos com sucesso!'
            ]);

        } else {
            return $this->responseNotOK("NF-e já cadastrada!", false);
        }

    
    }

    /**
     * @Route("/update/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update($id)
    {

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $doctrine = $this->getDoctrine();

        $check = $doctrine->getRepository(Checking::class)->find($id);

        $check->setOs($data['os']);
        $check->setStatus($data['status']);

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'O.P. alterada com sucesso!'
        ]);
    }

    /**
     * @Route("/status/{id}", name="status", methods={"PUT", "PATCH"})
     */
    public function status($id)
    {

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $doctrine = $this->getDoctrine();

        $check = $doctrine->getRepository(Checking::class)->find($id);

        $check->setStatus($data['status']);

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'Status Alterado com sucesso!'
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        $doctrine = $this->getDoctrine();
        $check = $doctrine->getRepository(Checking::class)->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($check);
        $manager->flush();

        return $this->json([
            'data' => 'O.S. apagada com sucesso!'
        ]);
    }
}
