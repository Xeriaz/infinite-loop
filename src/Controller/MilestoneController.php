<?php

namespace App\Controller;

use App\Entity\Challenges;
use App\Entity\Milestone;
use App\Entity\UserMilestoneStatus;
use App\Form\NewChallengeMilestoneForm;
use App\Form\NewChallengeMilestoneOwnerForm;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MilestoneController extends Controller
{
    /**
     * @Route("challenge/{id}/milestone/", name="milestone")
     * @param Request $request
     * @param int $id
     * @return Response|RedirectResponse
     */
    public function index(Request $request, int $id)
    {
        $challenge = $this->getDoctrine()->getRepository('App:Challenges')->find($id);

        if ($challenge->getOwner() !== $this->getUser()) {
            return $this->redirectToRoute('my_challenges');
        }

        $createNewFormOrRedirect = $this->new($request);

        if ($createNewFormOrRedirect instanceof RedirectResponse) {
            return $createNewFormOrRedirect;
        }

        $em = $this->getDoctrine()->getRepository('App:Challenges');

        return $this->render('new_milestone/index.html.twig', [
            'controller_name' => 'MilestoneController',
            'form' => $createNewFormOrRedirect,
            'challenge' => $em->find($id)
        ]);
    }

    /**
     * @param Request $request
     * @return FormView|RedirectResponse
     */
    private function new(Request $request)
    {
        $id = $request->attributes->get('id');

        /** @var Challenges $challenge */
        $challenge = $this->getDataById($id, Challenges::class);

        /** @var Milestone $milestone */
        $milestone = new Milestone();
        $milestone->setChallenge($challenge);
        $milestone->setOwner($this->getUser());

        if ($challenge->getOwner()->getId() === $this->getUser()->getId() && $challenge->getIsPublic()) {
            $formClass = NewChallengeMilestoneOwnerForm::class;
        } else {
            $formClass = NewChallengeMilestoneForm::class;
        }

        $form = $this->createForm($formClass, $milestone);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $milestone = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($milestone);
            $em->flush();

            if (!$milestone->getIsPublic()) {
                $em->persist($this->newUserMilestoneStatus($milestone));
                $em->flush();
            }

            return $this->redirectToRoute('challenge_details', ['id' => $id]);
        }

        return $form->createView();
    }

    /**
     * @param Milestone $milestone
     * @return UserMilestoneStatus
     */
    private function newUserMilestoneStatus(Milestone $milestone): UserMilestoneStatus
    {
        /** @var UserMilestoneStatus $newUserMilestoneStatus */
        $newUserMilestoneStatus = new UserMilestoneStatus();
        $newUserMilestoneStatus->setUser($this->getUser());
        $newUserMilestoneStatus->setMilestone($milestone);

        return $newUserMilestoneStatus;
    }

    /**
     * @param int $id
     * @param string $objectName
     * @return object
     */
    private function getDataById(int $id, string $objectName): object
    {
        $data = $this->getDoctrine()
            ->getRepository($objectName)
            ->find($id);

        if (!$data) {
            throw $this->createNotFoundException(
                'Nothing found for id ' . $id
            );
        }

        return $data;
    }

    /**
     * @param Milestone $milestone
     * @param string $objectName
     * @return object
     */
    private function getDataByMilestone(Milestone $milestone, string $objectName): object
    {
        $data = $this->getDoctrine()
            ->getRepository($objectName)
            ->findOneBy([
                'user' => $this->getUser(),
                'milestone' => $milestone
            ]);

        if (!$data) {
            $newUserMilestoneStatus = $this->newUserMilestoneStatus($milestone);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newUserMilestoneStatus);
            $em->flush();

            return $newUserMilestoneStatus;
        }

        return $data;
    }

    /**
     * @Route("/completed/milestone/{id}", name="complete_milestone")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function markMilestoneAsCompleted(Request $request): RedirectResponse
    {
        $milestoneId = $request->attributes->get('id');

        /** @var Milestone $milestone */
        $milestone = $this->getDataById($milestoneId, Milestone::class);

        if ($milestone->getOwner() !== $this->getUser()) {
            return $this->redirectToRoute('my_challenges');
        }

        /** @var UserMilestoneStatus $userMilestoneStatus */
        $userMilestoneStatus = $this->getDataByMilestone($milestone, UserMilestoneStatus::class);

        $userMilestoneStatus->setIsCompleted(true);
        $userMilestoneStatus->setSubmittedOn(new \DateTime('now'));

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('challenge_details', [
            'id' => $this->getChallengeId($userMilestoneStatus)
        ]);
    }

    /**
     * @param Request $request
     * @Route("/mark-as-removed/milestone/{id}", name="mark_as_removed_milestone")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function markMilestoneAsDeleted(Request $request): RedirectResponse
    {
        $id = $request->attributes->get('id');

        /** @var Milestone $milestone */
        $milestone = $this->getDataById($id, Milestone::class);

        if ($milestone->getOwner() !== $this->getUser()) {
            return $this->redirectToRoute('my_challenges');
        }

        /** @var UserMilestoneStatus $userMilestoneStatus */
        $userMilestoneStatus = $this->getDataByMilestone(
            $milestone,
            UserMilestoneStatus::class
        );

        $userMilestoneStatus->setIsDeleted(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('challenge_details', [
            'id' => $this->getChallengeId($userMilestoneStatus)
        ]);
    }

    /**
     * @param Request $request
     * @Route("/failed/milestone/{id}", name="failed_milestone")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function markMilestoneAsFailed(Request $request): RedirectResponse
    {
        $id = $request->attributes->get('id');

        /** @var Milestone $milestone */
        $milestone = $this->getDataById($id, Milestone::class);

        if ($milestone->getOwner() !== $this->getUser()) {
            return $this->redirectToRoute('my_challenges');
        }

        /** @var UserMilestoneStatus $userMilestoneStatus */
        $userMilestoneStatus = $this->getDataByMilestone(
            $milestone,
            UserMilestoneStatus::class
        );

        $userMilestoneStatus->setIsFailed(true);
        $userMilestoneStatus->setSubmittedOn(new \DateTime('now'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('challenge_details', [
            'id' => $this->getChallengeId($userMilestoneStatus)
        ]);
    }

    /**
     * @param Request $request
     * @Route("/remove/milestone/{id}", name="remove_milestone")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeCompletedMilestone(Request $request): RedirectResponse
    {
        $id = $request->attributes->get('id');

        /** @var Milestone $milestone */
        $milestone = $this->getDataById($id, Milestone::class);

        /** @var UserMilestoneStatus $userMilestoneStatus */
        $userMilestoneStatus = $this->getDataByMilestone(
            $milestone,
            UserMilestoneStatus::class
        );

        if ($milestone->getOwner() !== $this->getUser() ||
           ($userMilestoneStatus->getIsCompleted() || $userMilestoneStatus->getIsFailed())
        ) {
            $challengeId = $milestone->getChallenge()->getId();
            return $this->redirectToRoute('challenge_details', ['id' => $challengeId]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($milestone);
        $entityManager->remove($userMilestoneStatus);
        $entityManager->flush();

        return $this->redirectToRoute('challenge_details', [
            'id' => $this->getChallengeId($userMilestoneStatus)
        ]);
    }

    /**
     * @param UserMilestoneStatus $userMilestoneStatus
     * @return int
     */
    private function getChallengeId(UserMilestoneStatus $userMilestoneStatus): int
    {
        /** @var Milestone $milestone */
        $milestone = $userMilestoneStatus->getMilestone();

        /** @var Challenges $challenge */
        $challenge = $milestone->getChallenge();

        return $challenge->getId();
    }
}
