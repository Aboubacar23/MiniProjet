<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Etablissement;
use App\Entity\Membre;
use App\Entity\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Cin')
            ->add('Nom')
            ->add('Prenom')
            ->add('Email')
            ->add('Adresse')
            ->add('Statut',EntityType::class,[
                'class'=>Statut::class,
                'choice_label'=>'Nom'
            ])
            ->add('Equipe',EntityType::class,[
                'class'=>Equipe::class,
                'choice_label'=>'Nom'
            ])
            ->add('Etablissement',EntityType::class,[
                'class'=>Etablissement::class,
                'choice_label'=>'Nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
