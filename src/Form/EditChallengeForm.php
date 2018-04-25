<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditChallengeForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', TextType::class)
            ->add('Description', TextType::class, ['required' => false])
//            TODO add challengesGroups
//            ->add('challengesGroups', EntityType::class, [
//                'class' => ChallengesGroups::class,
//                'choice_label' => 'group_name',
//                'label' => 'Type',
//                'multiple' => true,
//            ])
            ->add('Start_date', DateType::class)
            ->add('End_date', DateType::class)
            ->add('update', SubmitType::class, ['label' => 'Update challenge'])
            ;
    }
}