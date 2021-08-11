<?php

namespace App\Form;


use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie',
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie',
                'html5' => true,
                'widget' => 'single_text',
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'label' => 'Date limite inscription',
                'html5' => true,
                'widget' => 'single_text',
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('nbInscriptionMax', IntegerType::class, [
                'label' => 'Nombre de place',
                'attr' =>[
                    'class' => 'form-control']

            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée',
                'attr' =>[
                    'class' => 'form-control']

            ])
            ->add('infosSortie', TextareaType::class,[
                'label' => 'Description',
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('ville', EntityType::class, [
                'class'=> Ville::class,
                'choice_label' => 'nom',
                'mapped'=>false,
                'attr' =>[
                    'class' => 'form-select']
            ])
            ->add('lieu', EntityType::class, [
                'class'=> Lieu::class,
                'choice_label' => 'nom',
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'latitude',
                'required' => false,
                'mapped' => false,
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'longitude',
                'required' => false,
                'mapped' => false,
                'attr' =>[
                    'class' => 'form-control']
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
