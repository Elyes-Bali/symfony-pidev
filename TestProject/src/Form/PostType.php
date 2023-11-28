<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('titre')
        ->add('sujet')
        ->add('image', FileType::class, [
            'label' => 'Image',
            'required' => false, // This allows an empty value (null) for optional uploads
            'mapped' => false,   // Not mapped to any property in the entity
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/*',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image file',
                ]),
            ],
        ])
        ->add('date', DateType::class, array(
            'required' => false,
            'widget' => 'single_text',

            'empty_data' => null,
            'attr' => array(
                'placeholder' => 'Date Match mm/dd/yyyy'
            )))
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
