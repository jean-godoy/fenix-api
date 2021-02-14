<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\RomaneioDescricao;
use App\Entity\SequenciaGrades;
use App\Entity\SequenciaOperacional;
use App\Entity\RomaneioFooter;

use App\Repository\RomaneioDescricaoRepository;
use App\Repository\SequenciaGradesRepository;
use App\Repository\SequenciaOperacionalRepository;
use App\Repository\RomaneioFooterRepository;

use App\Util\Traits\ResponseTrait;
use App\Service\OpService;

/**
 * @Route("/op", name="op_")
 */
class OpController extends AbstractController
{
    use ResponseTrait;
    private $opService;

    public function __construct(OpService $opService)
    {
        $this->opService = $opService;
    }

    /**
     * @Route("/", name="op", methods={"GET"})
     */
    public function index(): Response
    {
        $context['ignored_attributes'] = ['createdAt', 'deletedAt', 'updatedAt'];
        $reponse = $this->opService->getNfeNumber();

        if ($reponse !== null || $reponse !== "") {
            return $this->json($reponse, 200, [], $context);
        }

        return $this->json([
            'data' => 'Nenhuma NF-e Cadastrada!',
        ]);
    }

    /**
     * @Route("/upload-op", name="uploadOp", methods={"POST"})
     */
    public function uploadOp(Request $request)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $file = $_FILES['op_file']['tmp_name'];

        $data_now = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));

        $xml = simplexml_load_string(file_get_contents($file));
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);

        //ordem de producao
        $ordem_producao = $request->get('num_op');
        if ($ordem_producao === null || $ordem_producao === "") {
            return $this->responseNotOK("Campo Obrigatorio, ordem_produca", false);
        }

        // num NF-e
        $num_nfe = $request->get('num_nfe');
        if ($ordem_producao === null || $ordem_producao === "") {
            return $this->responseNotOK("Campo Obrigatorio, num_nfe", false);
        }

        //referencia
        $refString = $array["body"]["table"]["tr"][1]["td"]["p"]; //refe e cor
        $refPart = explode(" ", $refString);
        $referencia = $refPart[1];

        // cor
        $cor = $refPart[3];
        if ($cor === null || $cor === "") {
            $cor = 000000;
        }

        // descricao de servico
        $descString = explode(" - ", $refString);
        $descricao_servico = $descString[1];

        // semana
        $semanaString = $array["body"]["table"]["tr"][3]["td"][0]["p"];
        $semanaPart = explode(" ", $semanaString);
        $semana = $semanaPart[1];

        // os
        $osString = $array["body"]["table"]["tr"][3]["td"][1]["p"];
        $osPart = explode(" ", $osString);
        $os = $osPart[1];

        // valor
        $valor = null;
        $str = strlen($array["body"]["table"]["tr"][3]["td"][3]["p"]);
        if ($str <= 3) {
            $valor = $array["body"]["table"]["tr"][3]["td"][5]["p"];
        } else {
            $valor = $array["body"]["table"]["tr"][3]["td"][3]["p"];
        }

        //monta grade e tamanhos
        $quantidade = 0;
        $numGrade = count($array["body"]["table"]["tr"][4]["td"]) - 2;

        for ($i = 0; $i <= $numGrade; $i++) {
            $grade = new SequenciaGrades;

            $grade->setOp($ordem_producao);
            // ordem das grades
            $grade->setGrade($array["body"]["table"]["tr"][4]["td"][$i]["p"]);
            // quantidade das grades
            $grade->setQuantidade($array["body"]["table"]["tr"][6]["td"][$i]["p"]);
            // quantidade total
            $grade->setCreatedAt($data_now);
            $grade->setUpdatedAt($data_now);
            $grade->setNumNfe($num_nfe);
            //gera o grade code
            $grade->setGradeCode(md5(uniqid(rand() . "", true)));
            //gera quantidades
            $quantidade = $quantidade + $array["body"]["table"]["tr"][6]["td"][$i]["p"];

            $doctrine->persist($grade);
        }

        $doctrine->flush();

        $quantidade;

        // insercao na db romaneio_descricao
        $romaneio_descricao = new RomaneioDescricao();
        $romaneio_descricao->setOrdemProducao($ordem_producao);
        $romaneio_descricao->setReferencia($referencia);
        $romaneio_descricao->setCor($cor);
        $romaneio_descricao->setDescricaoServico($descricao_servico);
        $romaneio_descricao->setData($data_now);
        $romaneio_descricao->setSemana($semana);
        $romaneio_descricao->setOs($os);
        $romaneio_descricao->setQuantidade($quantidade);
        $romaneio_descricao->setValor($valor);
        $romaneio_descricao->setTipo("MOSTRUARIO");
        $romaneio_descricao->setCreatedAt($data_now);
        $romaneio_descricao->setUpdatedAt($data_now);
        $romaneio_descricao->setNumNfe($num_nfe);
        $romaneio_descricao->setStatus(5);

        $doctrine->persist($romaneio_descricao);
        $doctrine->flush();

        // Parte extração e geracao da sequencia operacional ok
        $number = Count($array["body"]["table"]["tr"]) - 2;


        for ($i = 8; $i <= $number; $i++) {
            $romaneio = new SequenciaOperacional();
            $romaneio->setReferenceCode(md5(uniqid(rand() . "", true)));
            $romaneio->setReferencia($referencia);
            $romaneio->setOrdemProducao($ordem_producao);
            $romaneio->setMaquina($array["body"]["table"]["tr"][$i]["td"][0]["p"]);
            $romaneio->setSequencia($array["body"]["table"]["tr"][$i]["td"][1]["p"]);
            $romaneio->setOperacao($array["body"]["table"]["tr"][$i]["td"][2]["p"]);
            $romaneio->setTempoComInt($array["body"]["table"]["tr"][$i]["td"][3]["p"]);
            $romaneio->setTempoSemInt($array["body"]["table"]["tr"][$i]["td"][4]["p"]);
            $romaneio->setPecasHora(intval($array["body"]["table"]["tr"][$i]["td"][5]["p"]));
            $romaneio->setCreatedAt($data_now);
            $romaneio->setUpdatedAt($data_now);
            $romaneio->setNumNfe($num_nfe);

            $doctrine->persist($romaneio);
        }

        $doctrine->flush();

        // grava parte do footer do romaneio

        $number = Count($array["body"]["table"]["tr"]) - 1;

        $atencao            = $array["body"]["table"]["tr"][$number]["td"][0]["p"];
        $total_sem_int      = $array["body"]["table"]["tr"][$number]["td"][2]["p"];
        $total_com_int      = $array["body"]["table"]["tr"][$number]["td"][3]["p"];
        $total_pecas_hora   = $array["body"]["table"]["tr"][$number]["td"][4]["p"];

        $footer = new RomaneioFooter();
        $footer->setOrdemProducao($ordem_producao);
        $footer->setAtencao($atencao);
        $footer->setTotalSemInt($total_sem_int);
        $footer->setTotalComInt($total_com_int);
        $footer->setTotalPecasHora($total_pecas_hora);
        $footer->setNumNfe($num_nfe);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($footer);
        $doctrine->flush();

        return $this->json([
            'data' => 'Ordem de Produção criada com sucesso!'
        ]);
    }
}
