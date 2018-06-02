<?php

namespace App\Controller;

use App\Entity\Challenges;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyChallengesController extends Controller
{
    /**
     * @Route("/list", name="my_challenges")
     */
    public function list(): Response
    {
        return $this->render('my_challenges/index.html.twig', [
            'controller_name' => 'MyChallengesController',
            'challenges' => $this->getUserChallenges()
        ]);
    }

    /**
     * @return Collection
     */
    private function getUserChallenges(): Collection
    {
        $user = $this->getUser();
        $challenges = $user->getChallenges();
        return $challenges;
    }
}
