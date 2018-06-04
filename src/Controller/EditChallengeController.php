<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Form\EditChallengeForm;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EditChallengeController extends Controller
{
    /**
     * @Route("/edit/challenge/{id}", name="edit_challenge")
     * @param  Request $request
     * @param int $id
     * @return Response
     */
    public function index(Request $request, int $id)
    {
        $createNewFormOrRedirect = $this->updateChallenge($request, $id);

        if ($createNewFormOrRedirect instanceof RedirectResponse) {
            return $createNewFormOrRedirect;
        }

        return $this->render('edit_challenge/index.html.twig', [
            'controller_name' => 'EditChallengeController',
            'form' => $createNewFormOrRedirect
        ]);
    }

    /**
     * @param int $id
     * @return Challenge
     */
    private function getChallengeData(int $id): Challenge
    {
        $challengeData = $this->getDoctrine()
            ->getRepository(Challenge::class)
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
     * @return FormView|RedirectResponse
     */
    private function updateChallenge(Request $request, int $id)
    {
        $challenge = $this->getChallengeData($id);

        $form = $this->createForm(EditChallengeForm::class, $challenge);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('challenge_details', ['id' => $id]);
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

        /** @var Challenge $challenge */
        $challenge = $this->getChallengeData($id);

        if ($challenge->getPublic()) {
            return $this->redirectToRoute('challenge_details', ['id' => $id]);
        }

        $challenge->setCompleted(true);
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

        if ($challenge->getOwner() !== $this->getUser()) {
            return $this->redirectToRoute('challenge_details', ['id' => $id]);
        }

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
        /** @var Challenge $challenge */
        $challenge = $this->getChallengeData($id);
        $challenge->addUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('my_challenges');
    }
}
