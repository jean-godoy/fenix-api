<?php

namespace App\Service;

use App\Repository\VocabularyRepository;
use App\Repository\CategoryRepository;

/**
 * Class VocabularyService
 * @package App\Entity
 * @author  Jean Godoy
 * @link http://mobilesales.com.br
 */

class VocabularyService
{
    /**
     * @var VocabularyRepository
     */
    protected $vocabularyRepository;
    protected $categoryRepository;

    public function __construct(
        VocabularyRepository $vocabularyRepository,
        CategoryRepository   $categoryRepository
    ) {
        $this->vocabularyRepository = $vocabularyRepository;
        $this->categoryRepository   = $categoryRepository;
    }

    public function getVocabulary($referenceCode)
    {
        $vocabulary = $this->vocabularyRepository->find(["reference_code" => $referenceCode]);
        //, "owner_id" => $owner_id
        if ($vocabulary !== null || $vocabulary !== "") {
            return $vocabulary;
        } else {
            return [];
        }
    }

    public function list($owner_id)
    {
        $vocabulary = $this->vocabularyRepository->findBy(["owner_id" => $owner_id]);

        if ($vocabulary !== null || $vocabulary !== "") {
            return $vocabulary;
        } else {
            return [];
        }
    }

    public function getCategory($category_id, $owner_id)
    {
        $category = $this->categoryRepository->findOneBy(["reference_code" => $category_id, "owner_id" => $owner_id, "deleted_at" => NULL]);
        return $category;
    }

    public function checkReferenceCode($reference_code, $owner_id)
    {
        $referenceCode = $this->vocabularyRepository->findOneBy(["reference_code" => $reference_code, "owner_id" => $owner_id, "deleted_at" => NULL]);

        if($referenceCode !== null || $referenceCode !== "")
        {
            return $referenceCode;
        }
    }
}
