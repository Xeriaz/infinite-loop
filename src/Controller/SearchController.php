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
     * @param Request $request
     * @Route("/search", name="search_query_info")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
        $searchQuery = $request->query->get('form');
        $searchQuery = $searchQuery['Search'];

        if ($searchQuery !== null) {
            $em = $this->getDoctrine()->getRepository('App:Challenges');
            $challenge = $em->searchChallengesByTitle($searchQuery, $this->getUser());
            $publicChallenge = $em->searchPublicChallengesByTitle($searchQuery);
        }

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'challenges' => $challenge,
            'publicChallenges' => $publicChallenge,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchBarAction()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('search_query_info'))
            ->setMethod('GET')
            ->add('Search', SearchType::class, [
                'label' => false,
                'attr' => ['class' => 'search__input', 'placeholder' => 'Search for challenge'],
            ])
//            ->add('Submit', SubmitType::class)
            ->getForm();

        return $this->render('includes/search.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
