<?php

namespace App\Controller;

use App\Entity\Challenges;
use App\Entity\Milestone;
use App\Form\NewChallengeMilestoneForm;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MilestoneController extends Controller
{
    /**
     * @Route("challenge/{id}/milestone/", name="milestone")
     */
    public function index(Request $request)
    {
        return $this->render('new_milestone/index.html.twig', [
            'controller_name' => 'MilestoneController',
            'form' => $this->new($request)

        ]);
    }

    public function new(Request $request): FormView
    {
        $id = $request->attributes->get('id');
        $challenge = $this->getDataById($id, Challenges::class);

        $milestone = new Milestone();
        $milestone->setChallenge($challenge);

        $form = $this->createForm(NewChallengeMilestoneForm::class, $milestone);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $milestone = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($milestone);
            $entityManager->flush();

            // TODO change route
//            return $this->redirectToRoute('home');
        }

        return $form->createView();
    }


    /**
     * @param int $id
     * @param string $object
     * @return object
     */
    private function getDataById(int $id, string $object): object
    {
        $data = $this->getDoctrine()
            ->getRepository($object)
            ->find($id);

        if (!$data) {
            throw $this->createNotFoundException(
                'Nothing found for id ' . $id
            );
        }

        return $data;
    }

    /**
     * @param Request $request
     * @Route("/completed/milestone/{id}", name="complete_milestone")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function markMilestoneAsCompleted (Request $request)
    {
        $id = $request->attributes->get('id');

        /** @var Milestone $milestone */
        $milestone = $this->getDataById($id, Milestone::class);
        $milestone->setStatus(true);
        $milestone->setCompletedOn(new \DateTime('now'));

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('my_challenges');
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
        $milestone->setDeleted(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('my_challenges');
    }
}
