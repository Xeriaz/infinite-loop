<?php

namespace App\Controller;

use App\Entity\Challenges;
use App\Form\EditChallengeForm;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EditChallengeController extends Controller
{
    /**
     * @Route("/edit/challenge/{id}", name="edit_challenge")
     */
    public function index(Request $request, int $id)
    {
        return $this->render('edit_challenge/index.html.twig', [
            'controller_name' => 'EditChallengeController',
            'form' => $this->updateChallenge($request, $id)
        ]);
    }

    /**
     * @param int $id
     * @return object
     */
    public function getChallengeData(int $id): object
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

    /**
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\Form\FormView
     */
    public function updateChallenge(Request $request, int $id): FormView
    {
        $challenge = $this->getChallengeData($id);

        $form = $this->createForm(EditChallengeForm::class, $challenge);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // TODO change route
//            return $this->redirectToRoute('my_challenges');
        }

        return $form->createView();
    }

    /**
     * @param int $id
     * @Route("/delete/challenge/{id}", name="delete_challenge")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeChallenge(int $id)
    {
        $challenge = $this->getChallengeData($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($challenge);
        $entityManager->flush();

        return $this->redirectToRoute('my_challenges');
    }
}
