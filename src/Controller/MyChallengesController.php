<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyChallengesController extends Controller
{
    /**
     * @Route("/my/challenges", name="my_challenges")
     */
    public function index()
    {
        return $this->render('my_challenges/index.html.twig', [
            'controller_name' => 'MyChallengesController',
        ]);
    }
}
