<?php

namespace App\Repository;

use App\Entity\Soucategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Soucategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Soucategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Soucategorie[]    findAll()
 * @method Soucategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoucategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Soucategorie::class);
    }

    // /**
    //  * @return Soucategorie[] Returns an array of Soucategorie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Soucategorie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
