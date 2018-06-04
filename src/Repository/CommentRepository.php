<?php

namespace App\Repository;

use App\Entity\Challenge;
use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function getChallengeComments(Challenge $challenge)
    {
        $qb = $this->createQueryBuilder('comment');

        $qb
            ->where(
                $qb->expr()->eq('comment.challenge', ':challenge')
            )
            ->setParameters([
                'challenge' => $challenge
            ])
        ;

        return $qb->getQuery()->getResult();
    }
}
