<?php

namespace App\Controller;

use App\Entity\Challenges;
use App\Entity\Milestone;
use App\Entity\UserMilestoneStatus;
use App\Form\NewChallengeMilestoneForm;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MilestoneController extends Controller
{

    /**
     * @Route("challenge/{id}/milestone/", name="milestone")
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, int $id)
    {
        return $this->render('new_milestone/index.html.twig', [
            'controller_name' => 'MilestoneController',
            'form' => $this->new($request),
            'challengeId' => $id
        ]);
    }

    /**
     * @param Request $request
     * @return FormView
     */
    public function new(Request $request): FormView
    {
        $id = $request->attributes->get('id');
        $challenge = $this->getDataById($id, Challenges::class);

        /** @var Milestone $milestone */
        $milestone = new Milestone();
        $milestone->setChallenge($challenge);

        $form = $this->createForm(NewChallengeMilestoneForm::class, $milestone);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $milestone = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($milestone);
            $em->flush();

            $em->persist($this->newUserMilestoneStatus($milestone));
            $em->flush();

            // TODO change route
//            return $this->redirectToRoute('my_challenges');
        }

        return $form->createView();
    }

    public function newUserMilestoneStatus(Milestone $milestone): UserMilestoneStatus
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
//            throw $this->createNotFoundException(
//                sprintf('You can not edit others milestones')
//            );
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
    public function markMilestoneAsCompleted (Request $request)
    {
        $milestoneId = $request->attributes->get('id');

        /** @var Milestone $milestone */
        $milestone = $this->getDataById($milestoneId, Milestone::class);

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
     * @Route("/remove/milestone/{id}", name="remove_milestone")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function markMilestoneAsDeleted (Request $request)
    {
        $id = $request->attributes->get('id');

        /** @var Milestone $milestone */
        $milestone = $this->getDataById($id, Milestone::class);

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
    public function markMilestoneAsFailed (Request $request)
    {
        $id = $request->attributes->get('id');

        /** @var Milestone $milestone */
        $milestone = $this->getDataById($id, Milestone::class);

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
     * @Route("/remove/completed/milestone/{id}", name="remove_completed_milestone")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeCompletedMilestone (Request $request)
    {
        $id = $request->attributes->get('id');

        /** @var Milestone $milestone */
        $milestone = $this->getDataById($id, Milestone::class);

        /** @var UserMilestoneStatus $userMilestoneStatus */
        $userMilestoneStatus = $this->getDataByMilestone(
            $milestone,
            UserMilestoneStatus::class
        );

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
