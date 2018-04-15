<?php

namespace App\Controller;

use App\Entity\ChallangesGroups;
use App\Form\NewChallengeGroupForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewChallengeGroupFormController extends Controller
{
    /**
     * @Route("/new/challenge/group/", name="new_challenge_group_form")
     */
    public function index(Request $request)
    {
        return $this->render('new_challenge_group_form/index.html.twig', [
            'controller_name' => 'NewChallengeGroupFormController',
            'form' => $this->new($request)
        ]);
    }

    public function new(Request $request)
    {
        $challengeGroup = new ChallangesGroups();
        $challengeGroup->setGroupName('');

        $form = $this->createForm(NewChallengeGroupForm::class, $challengeGroup);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $challengeGroup = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($challengeGroup);
            $entityManager->flush();

            // TODO change route
            return $this->redirectToRoute('home');
        }

        return $form->createView();
    }
}
