<?php

namespace App\Controller;

use App\Entity\Notification;
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

        $em = $this->getDoctrine()->getRepository('App:Notification');
        $notifications = $em->getAllNotifications($this->getUser());

        return $this->render('notifications/index.html.twig', [
            'controller_name' => 'NotificationsController',
            'notifications' => $notifications
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNotificationCount()
    {
        $em = $this->getDoctrine()->getRepository('App:Notification');
        $notifications = $em->getNewNotifications($this->getUser());

        return $this->render('includes/notification.html.twig', [
            'notifications' => $notifications
        ]);
    }


    /**
     * @param int $id
     * @Route("/notification/{id}", name="mark_notification_as_read")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function markAsRead(int $id)
    {
        $em = $this->getDoctrine()->getRepository('App:Notification');

        /** @var Notification $notification */
        $notification = $em->find($id);


        if ($notification->getUser()->getId() !== $this->getUser()->getId()) {
            return $this->redirectToRoute('notifications');
        }

        $notification->setRead(1);
        $notification->setReadOn(new \DateTime('now'));

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('notifications');
    }
}
