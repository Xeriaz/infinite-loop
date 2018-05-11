<?php

namespace App\Controller;

use App\Entity\Challenges;
use App\Form\EditChallengeForm;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
                'Nothing found for id ' . $id
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
     * @param Request $request
     * @Route("/complete/challenge/{id}", name="mark_challenge_completed")
     * @return RedirectResponse
     */
    public function markChallengeAsCompleted(Request $request)
    {
        $id = $request->attributes->get('id');

        /** @var Challenges $challenge */
        $challenge = $this->getChallengeData($id);
        $challenge->setIsCompleted(true);
        $challenge->setCompletedOn(new \DateTime('now'));

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('my_challenges');
    }

    /**
     * @param int $id
     * @Route("/delete/challenge/{id}", name="delete_challenge")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeChallenge(int $id)
    {
        $challenge = $this->getChallengeData($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($challenge);
        $em->flush();

        return $this->redirectToRoute('my_challenges');
    }


    /**
     * @Route("challenge/{id}/join-in", name="join_in_challenge")
     * @param int $id
     * @return RedirectResponse
     */
    public function otherUserJoinIn(int $id)
    {
        /** @var Challenges $challenge */
        $challenge = $this->getChallengeData($id);
        $challenge->addUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('home');
    }

    private function getAllMilestonesFromChallenge(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $challenge = $this->getChallengeData($id);

        // TODO userMilestoneStatus pagal challenge id ir owner id;

    }
}
