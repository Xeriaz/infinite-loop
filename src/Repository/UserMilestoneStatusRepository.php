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
}
