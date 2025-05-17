<?php

namespace App\Form;

use App\Entity\Document;
use App\Entity\DossierMedical;
use App\Entity\TypeDocument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dossier', EntityType::class, [
                'class' => DossierMedical::class,
                'placeholder'=>"-- Sélectionner le dossier médical -- "
            ])
            ->add('typeDocument', EntityType::class, [
                'class' => TypeDocument::class,
                'choice_label' => 'libelle',
                'placeholder'=>"-- Sélectionner le type du document  -- "
            ])

            ->add('fichier', DropzoneType::class, [
                'attr' => [
                    'placeholder' => 'Faites glisser et déposez un fichier ou cliquez pour parcourir',
                ],
                'label' => 'Image',
                'mapped' => false,
                'data_class' => null,
                'required'=>false

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
