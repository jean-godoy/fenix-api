<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Grade;
use App\Entity\Test;
use App\Repository\TestRepository;

/**
 * @Route("/test", name="test_")
 */
class TestController extends AbstractController
{

    private $testRepo;

    public function __construct(TestRepository $testRepository)
    {
        $this->testRepo = $testRepository;
    }

    /**
     * @Route("/all", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $grade = $this->getDoctrine()->getRepository(Grade::class)->findAll();

        return $this->json($grade);
    }

    /**
     * @Route("/number", name="number", methods={"GET"})
     */
    public function number()
    {
        $num = "0.2957";

        $test = new Test();
        $test->setTempoComInt($num);

        $doc = $this->getDoctrine()->getManager();
        $doc->persist($test);
        $doc->flush();

        return $this->json([]);
    }

    /**
     * @Route("/soma", name="soma", methods={"GET"})
     */
    public function soma()
    {
        // $test = $this->testRepo->findAll();
        $conn  = $this->getDoctrine()->getConnection();
        $sql = "SELECT tempo_com_int FROM test";
        $sql = $conn->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $response = $sql->fetchAll();
        }

        // var_dump($response);

        $total = null;

        foreach ($response as $item) {
            // $total =  ($item["tempo_com_int"] * 0.6) * 60;
            $total = $total + $item["tempo_com_int"];
        }

        var_dump($total);

        return $this->json([]);
    }

    /**
     * @Route("/pdf-to-jpg", name="pdfConverter", methods={"POST"})
     */
    public function pdfConverter(Request $request): Response
    {
        $json =  file_get_contents('php://input');
        $data = json_decode($json, true);
        $file = $_FILES['pdf_file'];
        // $pdf = simplexml_load_string(file_get_contents($file));

        $im = new imagick($file);
        $im->setImageFormat('jpg');
        header('Content-Type: image/jpeg');
        echo $im;

        var_dump($file);

        return $this->json($data, 200, [], []);
    }

    /**
     * @Route("/get-content", name="getContent", methods={"GET"})
     */
    public function getContent()
    {
        $url = 'https://www.yumpu.com/pt/document/read/64815386/cardapio-capitao';
        $data = file_get_contents($url);
        return $this->json($data);
    }
}
