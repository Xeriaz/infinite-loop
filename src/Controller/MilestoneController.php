<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MilestoneController extends Controller
{
    /**
     * @Route("/milestone", name="milestone")
     */
    public function index()
    {
        return $this->render('milestone/index.html.twig', [
            'controller_name' => 'MilestoneController',
        ]);
    }
}
