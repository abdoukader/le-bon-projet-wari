<?php

namespace App\Form;

use App\Entity\ClientEnvoie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnvoieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomE')
            ->add('prenomE')
            ->add('telE')
            ->add('nomR')
            ->add('prenomR')
            ->add('telR')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClientEnvoie::class,
        ]);
    }
}
