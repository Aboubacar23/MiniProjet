<?php

namespace App\Form;

use App\Entity\Membre;
use App\Entity\Publication;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre')
            ->add('Auteur')
            ->add('Document',FileType::class, [
                'label'=> 'Document (pdf file)',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new File([
                        'maxSize' => '1073741824k',
                        'mimeTypes'=> [
                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage'=>'veuillez choisir un document pdf',
                    ])
                ]
            ])
            ->add('Date_publication',DateType::class)
            ->add('Membre',EntityType::class, [
                'class'=>Membre::class,
                'choice_label'=>'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
