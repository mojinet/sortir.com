<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'label' => 'Nom de la sortie'
            ])
            ->add('dateHeureDebut', DateType::class, [
                'label' => 'Date et heure de la sortie',
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'label' => 'Date limite inscription',
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('nbInscriptionMax', IntegerType::class, [
                'label' => 'Nombre de place',

            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée',

            ])
            ->add('infosSortie', TextareaType::class,[
                'label' => 'Description et infos de la sortie'
            ])
//            ->add('campus', EntityType::class,[
//                'class'=> Campus::class,
//                'choice_label' => 'nom'
//            ])
            ->add('ville', EntityType::class, [
                'class'=> Ville::class,
                'choice_label' => 'nom',
                'mapped'=>false
            ])
            ->add('lieu', EntityType::class, [
                'class'=> Lieu::class,
                'choice_label' => 'nom'
            ])
            ->add('rue', TextType::class, [
                'label' => 'rue',
                'mapped' => false
            ])
            ->add('code_postal', TextType::class, [
                'label' => 'code postal',
                'mapped' => false
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'latitude',
                'required' => false,
                'mapped' => false
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'longitude',
                'required' => false,
                'mapped' => false
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
