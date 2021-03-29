<?php 

declare(strict_types=1);

namespace App\Service;

use App\Repository\FaccaoRomaneioRepository;

/**
 * Class TimeSerive
 * @package App\Entity
 * @author Jean Carlo Seide
 * @link https://www.seidesistemas.com.br 
 */

 class TimeService {

    /**
     * @var FaccaoRomaneioRepository
     */
    protected $faccaoRomaneio;

    public function __construct(
        FaccaoRomaneioRepository $faccaoRomaneioRepository
    )
    {
        $this->faccaoRomaneio = $faccaoRomaneioRepository;
    }

 }