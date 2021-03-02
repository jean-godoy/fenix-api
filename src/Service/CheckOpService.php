<?php  

declare(strict_types=1);

namespace App\Service;

use App\Repository\RomaneioDescricaoRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CheckOpService
 * @package App\Entityt
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class CheckOpService{
     

    /**
     * @var RomaneioDescricaoRepository
     */

     protected $romaneioDescricao;
     protected $em;

     public function __construct(
        RomaneioDescricaoRepository $romaneioDescricaoRepository,
        EntityManagerInterface      $entityManagerInterface
     )
     {
         $this->romaneioDescricao   = $romaneioDescricaoRepository;
         $this->em                  = $entityManagerInterface;
     }

     public function checkOp($op) 
     {
        $result = $this->romaneioDescricao->findOneBy(["ordem_producao" => $op]) ?? null;

        if($result === null || $result === "")
        {
            return false;
        }

        return $result;
     }

 }