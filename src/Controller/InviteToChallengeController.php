<?php

namespace App\Controller;

use App\Entity\Challenges;
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
        $challenge = $this->getDoctrine()->getRepository('App:Challenges')->find($id);

        if (!$challenge->getIsPublic()) {
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
        /** @var Challenges $challenge */
        $challenge = $this->getDataById($id, Challenges::class);

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
            $notification->setUser(
                $this->getUserByUsername(
                    $notification->getTargetedUsername()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notification);
            $entityManager->flush();

            return $this->redirectToRoute('challenge_details', ['id' => $id]);
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

    private function getUserByUsername(string $username): User
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy([
                'username' => $username
            ]);

        if (!$user) {
            throw $this->createNotFoundException(sprintf(
                'User %s was not found',
                $username
            ));
        }

        return $user;
    }
}
