<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\{NotBlank, Type};
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Evenements;

class Reservations1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('placesReservees', IntegerType::class, [
                'label' => 'Nombre de places réservées',
                'attr' => ['placeholder' => 'Entrez le nombre de places réservées'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer le nombre de places réservées.']),
                    new Type(['type' => 'numeric', 'message' => 'Veuillez entrer un nombre valide.']),
                ],
            ])
            ->add('participantId', IntegerType::class, [
                'label' => 'Identifiant du participant',
                'attr' => ['placeholder' => 'Entrez l\'identifiant du participant'],
                // Add constraints if necessary
            ])
            ->add('dateheureReservation', DateTimeType::class, [
                'label' => 'Date et heure de réservation',
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'Sélectionnez la date et l\'heure'],
                'html5' => false, // Allows custom date and time format
                'constraints' => [
                    new NotBlank(['message' => 'La date et l\'heure ne doivent pas être vides.']),
                    new Type(['type' => \DateTime::class, 'message' => 'Format de date invalide']),
                ],
            ])
            ->add('validate', null, [
                'label' => 'Validation',
                // Add other field options as needed
            ])
            ->add('evenement', EntityType::class, [
                'class' => Evenements::class,
                'label' => 'Événement associé',
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez un événement',
                'required' => true,
                // Add other field options as needed
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
