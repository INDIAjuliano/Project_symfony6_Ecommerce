<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom'
                ]
            ])
            ->add('lastname',  TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom'
                ]
            ])
            ->add('email', EmailType::class,[
                'label' => 'Votre eamil',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse email'
                ]
            ])

            // =====2 Type d'input de confirmation=======
            // ->add('roles')
            // ->add('password_confirm',PasswordType::class, [
            //     'type' => PasswordType::class,
            //     'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
            //     'label' => 'Confirme votre mot de passe',
            //     'mapped' => false, // ne doit pas lier à l'entity
            //     'required' => true, //ce champ est obligatoire
            //     'attr' => [
            //         'placeholder' => 'confirmez votre mot de passe'
            //     ]
            // ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'label' => 'Confirme votre mot de passe',
                'required' => true, //ce champ est obligatoire
                'first_options' => ['label'=> 'Mot de passe'],
                'second_options' => ['label'=> 'Confirmez votre passe'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "s'inscrire",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
