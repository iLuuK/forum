<?php

namespace App\Form;

use App\Entity\TicketComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TicketCommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Contenu : ',
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le champs doit comporter 5 caractères minimum'
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TicketComment::class,
        ]);
    }
}
