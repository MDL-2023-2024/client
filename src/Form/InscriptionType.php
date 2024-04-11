<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Inscription;
use App\Entity\Atelier;
use App\Entity\Nuite;
use App\Entity\Restauration;
use PharIo\Manifest\Email;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormTypeInterface;

class InscriptionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email de l\'envoie de la confirmation',
                'mapped' => false,
                'required' => true,
            ])
            ->add('ateliers', EntityType::class, [
                'class' => Atelier::class,
                'choice_label' => 'libelle', // Make sure 'libelle' is a valid property with a getter in Atelier
                'multiple' => true,
                'expanded' => true,
                
            ])
            ->add('nuites', CollectionType::class, [
                'entry_type' => NuiteFormType::class,
                'allow_add' => true,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'required' => false,
                'label' => false,
            ])
            ->add('restaurations' , EntityType::class, [
                'label' => 'Restauration pour l\'accompagnant',
                'class' => Restauration::class,
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => "S'inscrire",
                'attr' => ['class' => 'btn-primary m-auto d-block'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class, // Ensure Inscription is your correct data class
        ]);
    }
}
