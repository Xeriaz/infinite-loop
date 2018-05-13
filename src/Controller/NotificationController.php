<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends Controller
{

    /**
     * @param Request $request
     * @Route("/notifications/", name="notifications")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
//        $searchQuery = $request->query->get('form');
//        $searchQuery = $searchQuery['Search'];
//
//        if ($searchQuery !== null) {
//            $em = $this->getDoctrine()->getRepository('App:Challenges');
//            $challenge = $em->searchChallengesByTitle($searchQuery, $this->getUser());
//            $publicChallenge = $em->searchPublicChallengesByTitle($searchQuery);
//        }
//
//        return $this->render('search/index.html.twig', [
//            'controller_name' => 'SearchController',
//            'challenges' => $challenge,
//            'publicChallenges' => $publicChallenge,
//        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNotificationCount()
    {
        $em = $this->getDoctrine()->getRepository('App:Notification');
        $notificationCount = $em->getNotifications($this->getUser());

        return $this->render('includes/notification.html.twig', [
            'notifications' => $notificationCount
        ]);
    }
}
