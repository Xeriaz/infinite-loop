<?php

namespace App\Controller;

use App\Entity\Challenges;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\NewChallengeForm;

class NewChallengeFormController extends Controller
{
    /**
     * @Route("/new/challenge", name="new_challenge_form")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $createNewFormOrRedirect = $this->new($request);

        if ($createNewFormOrRedirect instanceof RedirectResponse) {
            return $createNewFormOrRedirect;
        }

        return $this->render('new_challenge_form/index.html.twig', [
            'controller_name' => 'NewChallengeFormController',
            'form' => $createNewFormOrRedirect
        ]);
    }

    /**
     * @param Request $request
     * @return FormView|RedirectResponse
     */
    public function new(Request $request)
    {
        $challenge = new Challenges();

        $challenge->setStartDate(new \DateTime('now'));
        $challenge->setEndDate(new \DateTime('now'));

        $challenge->setUsers((array($this->getUser())));
        $challenge->setOwner($this->getUser());

        $form = $this->createForm(NewChallengeForm::class, $challenge);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $challenge = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($challenge);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $form->createView();
    }
}
