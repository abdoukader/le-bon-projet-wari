<?php

namespace App\Form;

use App\Entity\ClientRetrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetraitType extends AbstractType
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
            ->add('CIN')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClientRetrait::class,
        ]);
    }
}
