<?php

namespace App\Form;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $actualSlug = $builder->getData()->getSlug();
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
            ->add('parent', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'required' => false,
                'attr' => [
                    'class' => 'form-select mb-3',
                ],
                'query_builder' => function (CategoryRepository $Cr) use ($actualSlug) {
                    if($actualSlug == null){
                        $actualSlug = "";
                    }
                    return $Cr->createQueryBuilder('c')
                        ->where('c.slug != :slug')
                        ->setParameter('slug', $actualSlug)
                        ->andWhere('c.is_deleted = :val')
                        ->setParameter('val', 0);
                },
                'label' => 'Parent : '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
