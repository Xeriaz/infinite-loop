<?php

namespace App\Repository;

use App\Entity\Challenges;
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

    public function getMilestones(Challenges $challenge, User $owner)
    {
        $qb = $this->createQueryBuilder('milestone');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('milestone.isPublic', ':private'),
                    $qb->expr()->eq('milestone.challenge', ':challenge'),
                    $qb->expr()->eq('milestone.owner', ':owner')
                )
            )
//            ->leftJoin(
//                'milestone.challenge',
//                'challenge',
//                Expr\Join::WITH,
//                'milestones.isPublic = :public'
//            )
            ->setParameters([
                'private'    => false,
                'challenge'  => $challenge,
                'owner'      => $owner,
//                'public'     => true,
            ]);

        return $qb->getQuery()->getResult();
    }

    public function getPublicChallenges(Challenges $challenge)
    {
        $qb = $this->createQueryBuilder('milestone');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('milestone.isPublic', ':public'),
                    $qb->expr()->eq('milestone.challenge', ':challenge')
                )
            )
            ->setParameters([
                'public'     => true,
                'challenge'  => $challenge,
            ]);

        return $qb->getQuery()->getResult();
    }

}
