<?php

namespace App\Repository;

use App\Entity\UserMilestoneStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserMilestoneStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMilestoneStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMilestoneStatus[]    findAll()
 * @method UserMilestoneStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMilestoneStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserMilestoneStatus::class);
    }

//    /**
//     * @return UserMilestone[] Returns an array of UserMilestone objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserMilestone
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
