<?php

namespace App\Repository;

use App\Entity\RomaneioDescricao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RomaneioDescricao|null find($id, $lockMode = null, $lockVersion = null)
 * @method RomaneioDescricao|null findOneBy(array $criteria, array $orderBy = null)
 * @method RomaneioDescricao[]    findAll()
 * @method RomaneioDescricao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RomaneioDescricaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RomaneioDescricao::class);
    }

    // /**
    //  * @return RomaneioDescricao[] Returns an array of RomaneioDescricao objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RomaneioDescricao
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
