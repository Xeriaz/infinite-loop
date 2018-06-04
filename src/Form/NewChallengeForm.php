<?php

namespace App\Form;

use App\Entity\ChallengeGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NewChallengeForm extends AbstractType
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
                'class' => ChallengeGroup::class,
                'choice_label' => 'group_name',
                'label' => 'Type',
                'multiple' => true,
            ])
            ->add('public', CheckboxType::class, [
                'label' => 'Is it public?',
                'required' => false
            ])
//            ->add('addProof', CheckboxType::class, [
//                'label' => "Add proof?",
//                'required' => false
//            ])
            ->add(
                'Start_date',
                DateType::class,
                ['years' => range(date('Y'), date('Y') + 5)]
            )

            ->add(
                'End_date',
                DateType::class,
                ['years' => range(date('Y'), date('Y') + 5)]
            )
            //->add('save', SubmitType::class, ['label' => 'Create challenge'])
            ;
    }
}
