<?php

namespace App\Form;

use App\Entity\Ticket;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\CategoryRepository;

class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'attr' => [
                'class' => 'form-control mb-3',
            ],
            'label' => 'Titre : ',
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
        ->add('content', TextareaType::class, [
            'attr' => [
                'class' => 'form-control mb-3',
            ],
            'label' => 'Contenu : ',
            'trim' => true,
            'constraints' => [
                new Length([
                    'min' => 5,
                    'minMessage' => 'Le champs doit comporter 5 caractères minimum'
                ]),
            ],
        ])
        ->add('category', EntityType::class, [
            'class' => Category::class,
            'choice_label' => 'title',
            'required' => true,
            'attr' => [
                'class' => 'form-select mb-3',
            ],
            'query_builder' => function (CategoryRepository $Cr) {
                return $Cr->createQueryBuilder('c')
                    ->where('c.is_deleted = :val')
                    ->setParameter('val', 0);
            },
            'label' => 'Catégorie : '
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
