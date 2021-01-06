<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\RomaneioDescricaoRepository;

/**
 * Class RomaneioDescricao
 * @package App\Entity
 * @author Jean Godoy
 * @link ttps://seidesistemas.com.br
 */

 class RomaneioService 
 {
     /**
      * @var RomaneioDescricaoRepository
      */

      protected $romaneioReposytory;

      public function __construct(
        RomaneioDescricaoRepository     $romaneioDescricaoRepository
      )
      {
          $this->romaneioReposytory     = $romaneioDescricaoRepository;
      }

      public function getRomaneio($op)
      {
          $romaneio = $this->romaneioReposytory->findOneBy(["ordem_producao" => $op]);

          if($romaneio !== null || $romaneio !== "")
          {
              return $romaneio;
          } else {
              return [];
          }
      }
 }