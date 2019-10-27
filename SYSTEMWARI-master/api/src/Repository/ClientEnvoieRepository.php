<?php

namespace App\Repository;

use App\Entity\ClientEnvoie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientEnvoie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientEnvoie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientEnvoie[]    findAll()
 * @method ClientEnvoie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientEnvoieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClientEnvoie::class);
    }

    // /**
    //  * @return ClientEnvoie[] Returns an array of ClientEnvoie objects
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
    public function findOneBySomeField($value): ?ClientEnvoie
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
