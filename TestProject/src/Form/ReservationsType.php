<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
class ReservationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('placesReservees', null, [
            'constraints' => [
                new NotBlank(['message' => 'Le nombre de places réservées ne peut pas être vide.']),
                new Positive(['message' => 'Le nombre de places réservées doit être un entier positif.']),
            ],
        ])
        ->add('participantId', null, [
            'constraints' => [
                new NotBlank(['message' => 'Le participant ID ne peut pas être vide.']),
            ],
        ])
        ->add('dateheureReservation')
        ->add('validate')
        ->add('evenement');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
