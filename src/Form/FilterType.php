<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use \Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('campus', EntityType::class,[
//                'class' => Campus::class,
//                'choice_label' => 'nom'
//            ])
            ->add('mots', SearchType::class,[
                'label' => 'Recherche par mot clef',
                'mapped' => false
            ])
//            ->add('dateHeureDebut', DateType::class, [
//                'label' => "date debut",
//                'html5'  => true,
//                'required' => false,
//                'widget' => 'single_text'
//            ])
//            ->add('duree', DateType::class, [
//                'label' => "date fin",
//                'html5'  => true,
//                'required' => false,
//                'widget' => 'single_text'
//            ])
//            ->add('organisateur', CheckboxType::class,[
//                'label' => 'Sortie dont je suis l\'organisateur',
//                'required' => false
//            ])
//            ->add('inscrit', CheckboxType::class,[
//                'label' => 'Sortie auxquelles je suis inscrit',
//                'required' => false
//            ])
//            ->add('pasInscrit', CheckboxType::class,[
//                'label' => 'Sortie auxquelles je ne suis pas inscrit',
//                'required' => false
//            ])
//            ->add('dejaPasse', CheckboxType::class,[
//                'label' => 'Sortie passées',
//                'required' => false
//            ])
            ->add('Rechercher', SubmitType::class, [
                'attr' =>[
                    'class' => 'btn'
                ]

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
