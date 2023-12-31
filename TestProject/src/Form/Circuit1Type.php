<?php

namespace App\Form;

use App\Entity\Circuit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Circuit1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix')
            ->add('depart')
            ->add('arrive')
            ->add('temps')
            ->add('categorie')
            ->add('description')
            ->add('pays')
            ->add('destination')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Circuit::class,
        ]);
    }
}
