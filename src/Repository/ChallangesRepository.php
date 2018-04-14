<?php

namespace App\Repository;

use App\Entity\Challanges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Challanges|null find($id, $lockMode = null, $lockVersion = null)
 * @method Challanges|null findOneBy(array $criteria, array $orderBy = null)
 * @method Challanges[]    findAll()
 * @method Challanges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallangesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Challanges::class);
    }

//    /**
//     * @return Challanges[] Returns an array of Challanges objects
//     */
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
    public function findOneBySomeField($value): ?Challanges
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
