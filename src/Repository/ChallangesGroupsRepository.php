<?php

namespace App\Repository;

use App\Entity\ChallangesGroups;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChallangesGroups|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChallangesGroups|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChallangesGroups[]    findAll()
 * @method ChallangesGroups[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallangesGroupsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChallangesGroups::class);
    }

//    /**
//     * @return ChallangesGroups[] Returns an array of ChallangesGroups objects
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
    public function findOneBySomeField($value): ?ChallangesGroups
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
