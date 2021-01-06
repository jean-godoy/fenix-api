<?php declare(strict_types=1);



namespace App\Util\Traits;

use Exception;
use Iterator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



trait ResponseTrait
{

    /**
     * @param \stdClass $data
     * @return JsonResponse
     */

    /**
     * @var Serializer
     */
    private $serializer;


    public function getSerializer(){
        if($this->serializer === null){
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $this->serializer  = new Serializer($normalizers, $encoders);
    
        }
        return $this->serializer;

    }

    public function strToJson($data, $serialize = true) 
    {
        $jsonContent = $data;

        if($serialize){
            $jsonContent = $this->getSerializer()->serialize($data, 'json');
            return $jsonContent;
        }
        return "";
    }

    public function responseOK($data, $serialize = true) : JsonResponse
    {
        $jsonContent = $data;

        if($serialize){
            $jsonContent = $this->getSerializer()->serialize($data, 'json');
        }

        $response = new JsonResponse();
        $response->setData($jsonContent);
        $response->setStatusCode(200);
        $response->setCharset('UTF-8');
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }

    public function responseNotOK($data, $serialize = true) : JsonResponse
    {
        $jsonContent = $data;

        if($serialize){
            $jsonContent = $this->getSerializer()->serialize($data, 'json');
        }

        $response = new JsonResponse();
        $response->setData($jsonContent);
        $response->setStatusCode(200);
        $response->setCharset('UTF-8');
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }

    public function responseLoginFail($data) : JsonResponse
    {
        $jsonContent = $data;


        $response = new JsonResponse();
        $response->setData($jsonContent);
        $response->setStatusCode(401);
        $response->setCharset('UTF-8');
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }
    

     public function obj2array (&$objeto ) {
        $clone = (array) $objeto;
        $rtn = array ();
        $retorno = array ();
        $rtn['___SOURCE_KEYS_'] = $clone;
    
        while ( list ($key, $value) = each ($clone) ) {
            $aux = explode ("\0", $key);
            $newkey = $aux[count($aux)-1];
            $theValue = &$rtn['___SOURCE_KEYS_'][$key];
            if (is_object($theValue) && get_class($theValue) == 'DateTime' ) {
                
                 $theValue = $theValue->format('Y-m-d H:i:s');
                
            }
            if (is_array($theValue) ) {
                $t =[];
                foreach($theValue as $v){
                    $t[] = $this->obj2array($v);
                }
                $theValue = $t;
           }

            $retorno[$newkey] = $theValue;
        }
    
        return $retorno;
    }

}