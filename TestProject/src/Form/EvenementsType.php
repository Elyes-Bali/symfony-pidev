<?php

namespace App\Form;

use App\Entity\Evenements;
use App\Entity\Categories;


use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Form\Type\CategoriesType;

class EvenementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {$builder
        ->add('nom', TextType::class, [
            'label' => 'Event Name',
            'attr' => ['placeholder' => 'Enter the event name'],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Event name should not be blank']),
                new Assert\Length(['min' => 3, 'max' => 255, 'minMessage' => 'Event name should be at least 3 characters', 'maxMessage' => 'Event name should be at most 255 characters']),
            ],
        ])
        ->add('datedebut', DateType::class, [
            'label' => 'Start Date',
            'widget' => 'single_text',
            'attr' => ['placeholder' => 'Select the start date'],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Start date should not be blank']),
                new Assert\Type(['type' => \DateTime::class, 'message' => 'Invalid date format']),
            ],
        ])
        // Add constraints for other fields...
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'attr' => ['placeholder' => 'Enter the description'],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Description should not be blank']),
            ],
        ])
      //  ->add('categorie', ChoiceType::class, [
           // 'placeholder' => 'choisir une catégorie',
            //'required' => true,
            //'multiple' => false,
            //'expanded' => false,
           // 'choices'  => [
             // 'loisir' => 'LOISIR',
              //'sport' => 'SPORT',
              //'aventure' => 'AVENTURE',
            //  'culture' => 'CULTURE',
            //  'bien-être' => 'BIEN-ETRE',
          //    'autre...' => 'AUTRE',
              
            //],
     //   ])
     ->add('categorie', EntityType::class, [
        'class' => Categories::class,
        'label' => 'Catégorie associé',
        'choice_label' => 'nom',
        'placeholder' => 'Sélectionnez la catégorie',
        'required' => true,
        // Add other field options as needed
    ])
        ->add('lieu', TextType::class, [
            'label' => 'Location',
            'attr' => ['placeholder' => 'Enter the location'],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Location should not be blank']),
            ],
        ])
        ->add('image', FileType::class, [
            'label' => 'Image',
            'mapped' => false,
            'required' => false,
            'attr' => ['placeholder' => 'Choose an image file'],
            'constraints' => [
                new Assert\Image(['mimeTypes' => ['image/jpeg', 'image/png'], 'mimeTypesMessage' => 'Please upload a valid image file (JPEG or PNG)']),
            ],
        ])
        ->add('tarif', MoneyType::class, [
            'label' => 'Price',
            'attr' => ['placeholder' => 'Enter the price'],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Price should not be blank']),
                new Assert\Type(['type' => 'numeric', 'message' => 'Price should be a numeric value']),
            ],
        ])
        ->add('placesDisponibles', IntegerType::class, [
            'label' => 'Available Seats',
            'attr' => ['placeholder' => 'Enter the available seats'],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Available seats should not be blank']),
                new Assert\Type(['type' => 'integer', 'message' => 'Available seats should be an integer']),
            ],
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenements::class,
        ]);
    }
}
