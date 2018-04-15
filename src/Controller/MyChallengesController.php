<?php

namespace App\Controller;

use App\Entity\Challenges;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyChallengesController extends Controller
{
    /**
     * @Route("/my/challenges", name="my_challenges")
     */
    public function index()
    {
        $this->getChallenges();
        return $this->render('my_challenges/index.html.twig', [
            'controller_name' => 'MyChallengesController',
            'challenges' => $this->getChallenges()
        ]);
    }

    public function getChallenges(): array
    {
        $challenges = $this->getDoctrine()
            ->getRepository(Challenges::class)
            ->findAll();

        return $challenges;
    }
}
