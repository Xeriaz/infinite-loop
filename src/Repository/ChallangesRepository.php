<?php

namespace App\Repository;

use App\Entity\Challenges;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Challenges|null find($id, $lockMode = null, $lockVersion = null)
 * @method Challenges|null findOneBy(array $criteria, array $orderBy = null)
 * @method Challenges[]    findAll()
 * @method Challenges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallangesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Challenges::class);
    }

    public function searchChallengesByTitle(string $title, User $user)
    {
        $qb = $this->createQueryBuilder('challenge');

        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('challenge.owner', ':owner'),
                    $qb->expr()->like('challenge.title', ':title'),
                    $qb->expr()->eq('challenge.isPublic', 0)
                )
            )
            ->setParameters([
                'owner' => $user,
                'title' => sprintf('%%%s%%', $title)
            ])
        ;

        return $qb->getQuery()->getResult();
    }

    public function searchPublicChallengesByTitle(string $title)
    {
        $qb = $this->createQueryBuilder('challenge');

        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->like('challenge.title', ':title'),
                    $qb->expr()->eq('challenge.isPublic', ':true')
                )
            )
            ->setParameters([
                'title' => sprintf('%%%s%%', $title),
                'true' => 1
            ])
        ;

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Challenges[] Returns an array of Challenges objects
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
    public function findOneBySomeField($value): ?Challenges
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
