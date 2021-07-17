<?php

namespace App\Repository;

use App\Entity\Produits;
use App\Entity\Commandes;
use App\Entity\CommandesProduits;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Commandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commandes[]    findAll()
 * @method Commandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commandes::class);
    }

    // /**
    //  * @return Commandes[] Returns an array of Commandes objects
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
    public function findOneBySomeField($value): ?Commandes
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function FinByUser($id){
        return $this->getEntityManager()
        ->createQuery('SELECT C.id,C.numcommande, P.designation,P.prixunitaire, P.quantite,C.etat
        FROM App\Entity\Produits P,
        App\Entity\Commandes C,
        App\Entity\CommandesProduits S
        WHERE  S.commande = C.id 
        AND S.produit = P.id
        AND C.user='.$id

       )->getResult();
        }

        public function Delete($id){
            return $this->getEntityManager()
            ->createQuery('DELETE
            FROM App\Entity\Produits P,
            App\Entity\Commandes C,
            App\Entity\CommandesProduits S
            WHERE  C.id = S.commande 
            AND S.produit = P.id
            AND C.id ='.$id
    
           )->getResult();
            }
}
