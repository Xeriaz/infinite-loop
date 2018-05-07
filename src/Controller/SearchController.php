<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends Controller
{
    /**
     * @Route("/search", name="search_query_info")
     */
    public function index(Request $request)
    {
        $searchQuery = $request->query->get('form');
        $searchQuery = $searchQuery['Search'];

            if ($searchQuery !== null) {
            $challenge = $this->getDoctrine()
                ->getRepository('App:Challenges')
                ->searchChallengesByTitle($searchQuery);
            dump($challenge);
        } else {
            $challenge = $this->getDoctrine()
                ->getRepository('App:Challenges')
                ->findAll();
        }

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'challenges' => $challenge,
        ]);
    }

    public function searchBarAction()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('search_query_info'))
            ->setMethod('GET')
            ->add('Search', SearchType::class, [
//                FIXME remove label
                'label' => ' '
            ])
            ->add('Submit', SubmitType::class)
            ->getForm();

        return $this->render('includes/search.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
