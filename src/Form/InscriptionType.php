<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Inscription;
use App\Entity\Atelier;
use App\Entity\CategorieChambre;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InscriptionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void 
        $builder
                ->add('ateliers', EntityType::class, [
                    'class' => Atelier::class,
                    'choice_label' => 'libelle', // Make sure 'libelle' is a valid property with a getter in Atelier
                    'multiple' => true,
                    'expanded' => true,
                ])
                ->add('nuites', EntityType::class, [
                    'class' => CategorieChambre::class,
                    'choice_label' => 'libelleCategorie',
                    'multiple' => true,
                    'expanded' => true,
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
