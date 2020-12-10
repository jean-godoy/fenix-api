<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\GenerateOp;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/generate-op", name="generate_")
 */
class GenerateOpController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $generate = $this->getDoctrine()->getRepository(GenerateOp::class)->findAll();

        return $this->json($generate);
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $op_decode = base64_decode($data['op_file']);
        $new_name = $op_decode . 'pdf';
        
        // $fileData = file_get_contents($_FILES['file']['tmp_name']);
        // var_dump($fileData);
        $file = fopen("/Users/usuario/projects/fenix/fenix_api/public/'.$new_name.'", "w");

        fwrite($file, $new_name);
        fclose($file);

        return $this->json(
            $data
        );
    }

    /**
     * @Route("/upload", name="upload", methods={"POST"})
     */
    public function upload()
    {
        $op = $_POST['op'];
        $fornecedor = $_POST['fornecedor'];
        // $data_in = $_POST['data_in'];
        $referencia = $_POST['referencia'];
        $cor = $_POST['cor'];
        $desc_servico = $_POST['desc_servico'];
        $semana = $_POST['semana'];
        $os = $_POST['os'];
        $quantidade = $_POST['quantidade'];
        $preco_unitario = $_POST['preco_unitario'];
        $tipo = $_POST['tipo'];

        $generate = New GenerateOp();

        $generate->setOp($op);
        $generate->setFornecedor($fornecedor);
        $generate->setDataIn(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $generate->setReferencia($referencia);
        $generate->setCor($cor);
        $generate->setDescService($desc_servico);
        $generate->setSemana($semana);
        $generate->setOs($os);
        $generate->setQuantidade($quantidade);
        $generate->setPrecoUnitario($preco_unitario);
        $generate->setTipo($tipo);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($generate);
        $doctrine->flush();

        //salva arquivo PDF no diretorio usando como referencia numero da op
        $filePDF = file_get_contents($_FILES['op_file']['tmp_name']);
        $file = fopen("/Users/usuario/projects/fenix/fenix_api/public/uploads/pdf/{$op}.pdf", "w");
        fwrite($file, $filePDF);
        fclose($file);

        //salva xml NO DIRETORIO usando como referencia numero da op
        $fileXML = file_get_contents($_FILES['xml_file']['tmp_name']);
        $dir = fopen("/Users/usuario/projects/fenix/fenix_api/public/uploads/xml/{$op}.xml", "w");
        fwrite($dir, $fileXML);
        fclose($dir);

        

        return $this->json([
            'data' => 'Ordem de Produção criada com sucesso!'
        ]);
    }
}
