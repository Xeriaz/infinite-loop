<?php

namespace App\Repository;

use App\Entity\ChallengesGroups;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChallengesGroups|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChallengesGroups|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChallengesGroups[]    findAll()
 * @method ChallengesGroups[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallangesGroupsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChallengesGroups::class);
    }

//    /**
//     * @return ChallengesGroups[] Returns an array of ChallengesGroups objects
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
    public function findOneBySomeField($value): ?ChallengesGroups
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
