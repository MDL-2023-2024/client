<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Inscription;
use App\Entity\Atelier;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InscriptionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('ateliers', EntityType::class, [
                    'class' => Atelier::class,
                    'choice_label' => 'libelle', // Make sure 'libelle' is a valid property with a getter in Atelier
                    'multiple' => true,
                    'expanded' => true,
                ])
                ->add('roomType', ChoiceType::class, [
                    'choices' => [
                        'Single' => 'single',
                        'Double' => 'double',
                    ],
                    'expanded' => true, // This makes it render as radio buttons
                ])
                ->add('enregistrer', SubmitType::class, [
                    'attr' => ['class' => 'btn-primary'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Inscription::class, // Ensure Inscription is your correct data class
        ]);
    }
}
