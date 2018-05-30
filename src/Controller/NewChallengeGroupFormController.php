<?php

namespace App\Controller;

use App\Entity\ChallengesGroups;
use App\Form\NewChallengeGroupForm;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewChallengeGroupFormController extends Controller
{
    /**
     * @Route("/new/challenge/group/", name="new_challenge_group_form")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        return $this->render('new_challenge_group_form/index.html.twig', [
            'controller_name' => 'NewChallengeGroupFormController',
            'form' => $this->new($request)
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormView
     */
    public function new(Request $request): FormView
    {
        $challengeGroup = new ChallengesGroups();
        $challengeGroup->setGroupName('');

        $form = $this->createForm(NewChallengeGroupForm::class, $challengeGroup);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $challengeGroup = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($challengeGroup);
            $entityManager->flush();

            // TODO change route
//            return $this->redirectToRoute('home');
        }

        return $form->createView();
    }
}
