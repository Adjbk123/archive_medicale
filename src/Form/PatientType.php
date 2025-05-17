<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'mapped'=>false
            ])
            ->add('prenoms', TextType::class, [
                'mapped'=>false,
                'label'=>'Prénoms'
            ])
            ->add('email', EmailType::class, [
                'label'=>"Adresse email",
                'mapped'=>false
            ])
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('adresse')
            ->add('telephone', TelType::class,[
                'label'=>'Téléphone'
            ])
            ->add('password', RepeatedType::class,[
                'type'=>PasswordType::class,
                'first_options'=>[
                    'label'=>'Mot de passe'
                ],
                'second_options'=>[
                    'label'=>'Confirmation du mot de passe'
                ],
                'mapped'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
