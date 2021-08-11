<?php

namespace App\Form;

use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', null,[
            'label' => 'Ville',
            'required' => true,
            'attr' =>[
                'class' => 'form-control']
        ])
        ->add('codePostal', null,[
            'label' => 'Code Postal',
            'required' => true,
            'attr' =>[
                'class' => 'form-control']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,
        ]);
    }
}
