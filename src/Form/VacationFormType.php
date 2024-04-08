<?php

namespace App\Form;

use App\Entity\Vacation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire de création et de modification d'une vacation.
 */
class VacationFormType extends AbstractType
{
    /**
     * Construit le formulaire de création et de modification d'une vacation.
     *
     * @param FormBuilderInterface $builder Le constructeur de formulaire.
     * @param array<string, mixed> $options Les options du formulaire.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateheureDebut')
            ->add('dateheureFin')
            ->add('atelier')
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
            'data_class' => Vacation::class,
        ]);
    }
}
