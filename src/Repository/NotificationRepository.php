<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getNewNotifications(User $user)
    {
        $qb = $this->createQueryBuilder('notification');

        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('notification.read', ':false'),
                    $qb->expr()->eq('notification.user', ':user')
                )
            )
            ->setParameters([
                'false' => 0,
                'user' => $user
            ])
        ;

        return $qb->getQuery()->getResult();
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function getAllNotifications(User $user)
    {
        $qb = $this->createQueryBuilder('notification');

        $qb
            ->where(
                $qb->expr()->eq('notification.user', ':user')
            )
            ->setParameters([
                'user' => $user
            ])
            ->orderBy('notification.read', 'ASC')
            ->orderBy('notification.createdOn', 'DESC');
        ;

        return $qb->getQuery()->getResult();
    }
}
