<?php

namespace App\Form;

use App\Entity\Hebergement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class HebergementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('capacite',TextType::class, [
                'attr' => [
                    'placeholder' => 'Capacite',
                ]
            ])
            ->add('prix',TextType::class, [
                'attr' => [
                    'placeholder' => 'Prix',
                ]
            ])
            ->add('adresse',TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse',
                ]
            ])
            ->add('type',TextType::class, [
                'attr' => [
                    'placeholder' => 'Type',
                ]
            ])
            ->add('description',TextAreaType::class, [
                'attr' => [
                    'placeholder' => 'Description',
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => 'App\Entity\CategorieHeb',
                'choice_label' => 'contenu',
                'placeholder' => 'Veuillez choisir la categorie.'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hebergement::class,
        ]);
    }
}
