<?php

namespace App\Controller;

use App\Entity\ChallengeGroup;
use App\Form\NewChallengeGroupForm;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @return FormView|RedirectResponse
     */
    private function new(Request $request)
    {
        $challengeGroup = new ChallengeGroup();
        $challengeGroup->setGroupName('');

        $form = $this->createForm(NewChallengeGroupForm::class, $challengeGroup);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $challengeGroup = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($challengeGroup);
            $entityManager->flush();
        }

        return $form->createView();
    }
}
