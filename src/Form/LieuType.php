<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,[
                'label' => 'Nom',
                'required' => true,
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('rue', null,[
                'label' => 'Rue',
                'required' => true,
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('latitude', null,[
                'label' => 'Latitude',
                'required' => true,
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('longitude', null,[
                'label' => 'Longitude',
                'required' => true,
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('ville', EntityType::class,[
                'class' => Ville::class,
                'choice_label' => 'nom',
                'attr' =>[
                    'class' => 'form-select']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
