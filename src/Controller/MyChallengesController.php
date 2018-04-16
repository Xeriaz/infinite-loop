<?php

namespace App\Controller;

use App\Entity\Challenges;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyChallengesController extends Controller
{
    /**
     * @Route("/challenges/list", name="my_challenges")
     */
    public function list(): Response
    {
        return $this->render('my_challenges/index.html.twig', [
            'controller_name' => 'MyChallengesController',
            'challenges' => $this->getChallenges()
        ]);
    }

    /**
     * @return array
     */
    public function getChallenges(): array
    {
        $challenges = $this->getDoctrine()
            ->getRepository(Challenges::class)
            ->findAll();

        return $challenges;
    }
}
