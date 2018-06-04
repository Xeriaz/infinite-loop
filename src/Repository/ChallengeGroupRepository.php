<?php

namespace App\Repository;

use App\Entity\ChallengeGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChallengeGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChallengeGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChallengeGroup[]    findAll()
 * @method ChallengeGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengeGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChallengeGroup::class);
    }
}
