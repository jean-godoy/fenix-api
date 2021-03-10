<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Class Money
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class MoneyService {

    public function toUsd(String $value)
    {
        // Remove o ponto
        $value = str_replace('.', '', $value);
        // Troca o a virgula pelo ponto
        $value = str_replace(',', '.', $value);

        return $value;
    }

 }