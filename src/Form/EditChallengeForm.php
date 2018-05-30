<?php

namespace App\Form;

use App\Entity\ChallengesGroups;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('challengeGroup', EntityType::class, [
                'class' => ChallengesGroups::class,
                'choice_label' => 'group_name',
                'label' => 'Type',
                'multiple' => true,
            ])
            ->add('isPublic', CheckboxType::class, [
                'label' => 'Is it public?',
                'required' => false
            ])
            ->add('addProof', CheckboxType::class, [
                'label' => "Add proof?",
                'required' => false
            ])
            ->add('Start_date', DateType::class)
            ->add('End_date', DateType::class)
//            ->add('update', SubmitType::class, ['label' => 'Update challenge'])
            ;
    }
}
