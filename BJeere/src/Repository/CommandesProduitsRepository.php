<?php

namespace App\Repository;

use App\Entity\CommandesProduits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandesProduits|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandesProduits|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandesProduits[]    findAll()
 * @method CommandesProduits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandesProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandesProduits::class);
    }

    // /**
    //  * @return CommandesProduits[] Returns an array of CommandesProduits objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommandesProduits
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
