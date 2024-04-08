<?php

namespace App\Form;

use App\Entity\CategorieChambre;
use App\Entity\Hotel;
use App\Entity\Nuite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NuiteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateNuitee', null, [
                'label' => false,
                'attr' => ['style' => 'display:none'],
                'data' => new \DateTime(),
            ])
            ->add('categorie', EntityType::class, [
                'class' => CategorieChambre::class,
                'choice_label' => 'libelleCategorie',
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('hotel', EntityType::class, [
                'class' => Hotel::class,
                'choice_label' => 'pnom', // Make sure 'libelle' is a valid property with a getter in Atelier
                'multiple' => false,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nuite::class,
        ]);
    }
}
