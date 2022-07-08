<?php

namespace App\Form;

use App\Model\UpdatePassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UpdatePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('oldPassword', PasswordType::class, [
            'mapped' => true,
            'attr' => [
                'class' => 'form-control mb-3'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Confirmez votre mot de passe actuel',
                ])
            ],
            'label' => 'Confirmez votre mot de passe actuel : '
        ])
        ->add('newPassword', RepeatedType::class, [
            'type' => PasswordType::class,            
            'mapped' => true,
            'options' => ['attr' => ['class' => 'form-control mb-3']],
            'constraints' => [
                new NotBlank([
                    'message' => 'Entrez un mot de passe',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Le mot de passe doit faire 6 caractères minimum.',
                    'max' => 4096,
                ]),
            ],
            'first_options'  => ['label' => 'Nouveau mot de passe :'],
            'second_options' => ['label' => 'Vérifier nouveau mot de passe'],
            'invalid_message' => 'Les mots de passes ne correspondent pas'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdatePassword::class,
        ]);
    }
}
