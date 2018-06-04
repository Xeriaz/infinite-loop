<?php

namespace App\Repository;

use App\Entity\Challenge;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Challenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Challenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Challenge[]    findAll()
 * @method Challenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Challenge::class);
    }

    public function searchChallengesByTitle(string $title, User $user)
    {
        $qb = $this->createQueryBuilder('challenge');

        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('challenge.owner', ':owner'),
                    $qb->expr()->like('challenge.title', ':title'),
                    $qb->expr()->eq('challenge.public', 0)
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
                    $qb->expr()->eq('challenge.public', ':true')
                )
            )
            ->setParameters([
                'title' => sprintf('%%%s%%', $title),
                'true' => 1
            ])
        ;

        return $qb->getQuery()->getResult();
    }
}
