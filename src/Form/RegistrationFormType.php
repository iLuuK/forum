<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Pseudo : ',
                'trim' => true,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le champs doit comporter 5 caractères minimum',
                        'max' => 100,
                        'maxMessage' => 'Le champs doit comporter 100 caractères maximum',
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Prénom : ',
                'trim' => true,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le champs doit comporter 5 caractères minimum',
                        'max' => 100,
                        'maxMessage' => 'Le champs doit comporter 100 caractères maximum',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Nom : ',
                'trim' => true,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le champs doit comporter 5 caractères minimum',
                        'max' => 100,
                        'maxMessage' => 'Le champs doit comporter 100 caractères maximum',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Votre addresse (numéro et nom de rue) : ',
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le champs doit comporter 5 caractères minimum',
                        'max' => 255,
                        'maxMessage' => 'Le champs doit comporter 255 caractères maximum',
                    ]),
                ],
            ])
            ->add('postal_code', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Code postal : ',
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le champs doit comporter 5 caractères minimum',
                        'max' => 100,
                        'maxMessage' => 'Le champs doit comporter 100 caractères maximum',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Ville : ',
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le champs doit comporter 5 caractères minimum',
                        'max' => 100,
                        'maxMessage' => 'Le champs doit comporter 100 caractères maximum',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'trim' => true,
                'label' => 'E-mail : '
            ])
            ->add('phone_number', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Numéro téléphone (10 chiffres) : ',
                'trim' => true,
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'max' => 10,
                        'exactMessage' => 'Le téléphone doit être au format 10 chiffres',
                    ])
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Vous devez accepter les conditions : ',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control'
                ],
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
                'label' => 'Mot de passe : '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
