<?php

namespace App\Form;

use App\Entity\Compte;
use App\Entity\Inscription;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectInscriptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('compte', EntityType::class, [
                'class' => Compte::class,
                'choice_label' => 'numLicence', // Make sure 'numLicence' is a valid property with a getter in Compte
                'multiple' => false,
                'expanded' => false,
                'required' => false,
            ])
            ->add('inscription', EntityType::class, [
                'class' => Inscription::class,
                'choice_label' => 'id', // Make sure 'numLicence' is a valid property with a getter in Entity
                'multiple' => false,
                'expanded' => false,
                'required' => false,
            ])
            ->add('confirmer', SubmitType::class, [
                'label' => 'Confirmer',
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
