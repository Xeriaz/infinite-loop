<?php

namespace App\Controller;

use App\Entity\Challenges;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\NewChallengeForm;

class NewChallengeFormController extends Controller
{
    /**
     * @Route("/new/challenge", name="new_challenge_form")
     */
    public function index(Request $request)
    {
        return $this->render('new_challenge_form/index.html.twig', [
            'controller_name' => 'NewChallengeFormController',
            'form' => $this->new($request)
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormView
     */
    public function new(Request $request): FormView
    {
        $challenge = new Challenges();
        $challenge->setTitle('');
        $challenge->setDescription('');
        $challenge->setStartDate(new \DateTime('now'));
        $challenge->setEndDate(new \DateTime('now'));

        $form = $this->createForm(NewChallengeForm::class, $challenge);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $challenge = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($challenge);
            $entityManager->flush();

            // TODO change route
//            return $this->redirectToRoute('home');
        }

        return $form->createView();
    }
}
