<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\Milestone;
use App\Entity\UserMilestoneStatus;
use App\Form\EditChallengeForm;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

        $notSubmittedMilestones = $this->findNotSubmittedMilestones($challenge->getMilestones());
        $this->markNotSubmittedMilestonesAsFailed($notSubmittedMilestones);

        $this->addFlash(
            'success',
            sprintf('Congratulations! You have completed "%s" challenge', $challenge->getTitle())
        );
        return $this->redirectToRoute('challenge_details', ['id' => $id]);
    }

    /**
     * @param Collection $milestones
     * @return array
     */
    private function findNotSubmittedMilestones(Collection $milestones): array
    {
        $notSubmittedMilestone = [];

        $em = $this->getDoctrine()->getRepository('App:UserMilestoneStatus');

        foreach ($milestones as $milestone) {
            $userMilestoneStatus = $em->findBy(
                [
                    'milestone' => $milestone,
                    'user' => $this->getUser(),
                    'submittedOn' => null,
                    'completed' => 0,
                    'failed' => 0
                ]
            );

            if (isset($userMilestoneStatus) && $userMilestoneStatus != null) {
                $notSubmittedMilestone[] = $userMilestoneStatus;
            }
        }

        if (count($notSubmittedMilestone) > 0) {
            $this->addFlash(
                'danger',
                sprintf('%d milestones was marked as failed', count($notSubmittedMilestone))
            );
        }
        return $notSubmittedMilestone;
    }

    /**
     * @param array $milestones
     */
    private function markNotSubmittedMilestonesAsFailed(array $milestones): void
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($milestones as $milestoneStatusArray) {
            foreach ($milestoneStatusArray as $milestone) {
                $milestone->setSubmittedOn(new \DateTime('now'));
                $milestone->setFailed(1);
            }
        }

        $em->flush();
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

        $this->addFlash('warning', sprintf('Challenge "%s" was removed', $challenge->getTitle()));
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

        $this->addFlash('info', sprintf('You joined "%s" challenge', $challenge->getTitle()));
        return $this->redirectToRoute('my_challenges');
    }
}
