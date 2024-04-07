<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Theme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire de création et de modification d'un thème.
 */
class ThemeFormType extends AbstractType
{
    /**
     * Construit le formulaire de création et de modification d'un thème.
     *
     * @param FormBuilderInterface $builder Le constructeur de formulaire.
     * @param array<string, mixed> $options Les options du formulaire.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('ateliers', EntityType::class, [
                'class' => Atelier::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn-primary'],
            ])
        ;
    }

    /**
     * Configure les options du formulaire.
     *
     * @param OptionsResolver $resolver Le résolveur d'options.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Theme::class,
        ]);
    }
}
