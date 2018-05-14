<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChallengeDetailsController extends Controller
{
    /**
     * @param int $id
     * @Route("/challenge/details/{id}", name="challenge_details")
     * @return Response
     */
    public function index(int $id)
    {
        $em = $this->getDoctrine()->getRepository('App:Challenges');
        $challenge = $em->find($id);

        return $this->render('challenge_details/index.html.twig', [
            'controller_name' => 'ChallengeDetailsController',
            'challenge' => $challenge
        ]);
    }

}
