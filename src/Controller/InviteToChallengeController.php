<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\Notification;
use App\Entity\User;
use App\Form\InviteToChallengeForm;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InviteToChallengeController extends Controller
{
    /**
     * @Route("/invite-to-challenge/{id}", name="invite_user_to_challenge")
     * @param Request $request
     * @param int $id
     * @return Response|RedirectResponse
     */
    public function index(Request $request, int $id)
    {
        $challenge = $this->getDoctrine()->getRepository('App:Challenge')->find($id);

        if (!$challenge->getPublic()) {
            return $this->redirectToRoute('challenge_details', ['id' => $id]);
        }

        $createNewFormOrRedirect = $this->inviteUser($request, $id);

        if ($createNewFormOrRedirect instanceof RedirectResponse) {
            return $createNewFormOrRedirect;
        }

        return $this->render('invite_user_to_challenge_form/index.html.twig', [
            'controller_name' => 'InviteUserController',
            'form' => $createNewFormOrRedirect
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return FormView|RedirectResponse
     */
    private function inviteUser(Request $request, int $id)
    {
        /** @var Challenge $challenge */
        $challenge = $this->getDataById($id, Challenge::class);

        /** @var Notification $notification */
        $notification = new Notification();
        $notification->setCreatedOn(new \DateTime('now'));
        $notification->setDescription(sprintf(
            '%s invited You to join %s challenge',
            $this->getUser(),
            $challenge->getTitle()
        ));
        $notification->setChallenge($challenge);

        $form = $this->createForm(InviteToChallengeForm::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification = $form->getData();

            $userOrRedirect = $this->getUserByUsername($notification->getTargetedUsername(), $id);

            if ($userOrRedirect instanceof User) {
                $notification->setUser($userOrRedirect);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($notification);
                $entityManager->flush();

                return $this->redirectToRoute('challenge_details', ['id' => $id]);
            }
        }

        return $form->createView();
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
     * @param string $username
     * @return User|RedirectResponse
     */
    private function getUserByUsername(string $username, int $id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy([
                'username' => $username
            ]);

        if (!$user) {
            $this->addFlash('danger', sprintf('User %s was not found', $username));
            return $this->redirectToRoute('invite_user_to_challenge', ['id' => $id]);
        }

        return $user;
    }
}
