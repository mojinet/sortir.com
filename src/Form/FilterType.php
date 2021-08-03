<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use \Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class,[
                'class' => Campus::class,
                'choice_label' => 'nom'
            ])
            ->add('filtreMot', null,[
                'label' => 'Le nom de la sortie contient'
            ])
            ->add('dateHeureDebut', DateType::class, [
                'label' => "date debut",
                'html5'  => true,
                'widget' => 'single_text'
            ])
            ->add('duree', DateType::class, [
                'label' => "date fin",
                'html5'  => true,
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
