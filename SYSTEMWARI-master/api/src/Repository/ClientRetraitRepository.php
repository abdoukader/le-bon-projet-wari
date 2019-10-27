<?php

namespace App\Repository;

use App\Entity\ClientRetrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientRetrait|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientRetrait|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientRetrait[]    findAll()
 * @method ClientRetrait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRetraitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClientRetrait::class);
    }

    // /**
    //  * @return ClientRetrait[] Returns an array of ClientRetrait objects
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
    public function findOneBySomeField($value): ?ClientRetrait
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
