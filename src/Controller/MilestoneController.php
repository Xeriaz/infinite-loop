<?php

namespace App\Controller;

use App\Entity\Challenges;
use App\Entity\Milestone;
use App\Form\NewChallengeMilestoneForm;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MilestoneController extends Controller
{
    /**
     * @Route("challenge/{id}/milestone/", name="milestone")
     */
    public function index(Request $request)
    {
        return $this->render('new_milestone/index.html.twig', [
            'controller_name' => 'MilestoneController',
            'form' => $this->new($request)

        ]);
    }

    public function new(Request $request): FormView
    {
        $id = $request->attributes->get('id');

        $challenge = $this->getChallengeData($id);

        $milestone = new Milestone();
        $milestone->setChallenge($challenge);

        $form = $this->createForm(NewChallengeMilestoneForm::class, $milestone);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $milestone = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($milestone);
            $entityManager->flush();

            // TODO change route
//            return $this->redirectToRoute('home');
        }

        return $form->createView();
    }

    /**
     * @param int $id
     * @return object
     */
    private function getChallengeData(int $id): object
    {
        $challengeData = $this->getDoctrine()
            ->getRepository(Challenges::class)
            ->find($id);

        if (!$challengeData) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        return $challengeData;
    }
}
