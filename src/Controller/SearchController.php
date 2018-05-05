<?php

namespace App\Controller;

use App\Form\SearchForm;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    public function searchBarAction()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('home'))
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
