<?php

namespace App\Form;

use App\Entity\Reponsereclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponsereclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idu')
            ->add('prenom')
            ->add('intitule')
            ->add('textreprec')
            ->add('idrec')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponsereclamation::class,
        ]);
    }
}
