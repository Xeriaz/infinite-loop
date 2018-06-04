<?php

namespace App\Repository;

use App\Entity\Challenge;
use App\Entity\Milestone;
use App\Entity\User;
use App\Entity\UserMilestoneStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr;

/**
 * @method Milestone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Milestone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Milestone[]    findAll()
 * @method Milestone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilestoneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Milestone::class);
    }

    public function getMilestonesByChallengeAndUser(Challenge $challenge, User $owner)
    {
        $qb = $this->createQueryBuilder('milestone');
        $qb
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->andX(
                        $qb->expr()->eq('milestone.isPublic', $qb->expr()->literal(false)),
                        $qb->expr()->eq('milestone.challenge', ':challenge'),
                        $qb->expr()->eq('milestone.owner', ':owner')
                    ),
                    $qb->expr()->andX(
                        $qb->expr()->eq('milestone.isPublic', $qb->expr()->literal(true)),
                        $qb->expr()->eq('milestone.challenge', ':challenge')
                    )
                )
            )
            ->setParameters(
                [
                'challenge'  => $challenge,
                'owner'      => $owner,
                ]
            );

        return $qb->getQuery()->getResult();
    }
}
