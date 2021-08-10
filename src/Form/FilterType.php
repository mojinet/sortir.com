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
            ->add('campus', EntityType::class,[
                'class' => Campus::class,
                'label' => false,
                'required' => false,
                'choice_label' => 'nom',
                'placeholder' => 'Campus'
            ])
            ->add('mots', SearchType::class,[
                'label' => false,
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Recherche par mot clef'
                ]
            ])

            ->add('dateHeureDebut', DateType::class, [
                'label' => "date de début",
                'html5'  => true,
                'required' => false,
                'mapped' => false,
                'widget' => 'single_text'
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'label' => "date de fin",
                'html5'  => true,
                'required' => false,
                'mapped' => false,
                'widget' => 'single_text'
            ])
            ->add('Rechercher', SubmitType::class, [
                'attr' =>[
                    'class' => 'btn'
                ]
            ])
            ->add('organisateur', CheckboxType::class,[
                'label' => 'Sortie dont je suis l\'organisateur',
                'required' => false,
                'mapped' => false
            ])
            ->add('inscrit', CheckboxType::class,[
                'label' => 'Sortie auxquelles je suis inscrit',
                'required' => false,
                'mapped' => false
            ])
            ->add('pasInscrit', CheckboxType::class,[
                'label' => 'Sortie auxquelles je ne suis pas inscrit',
                'required' => false,
                'mapped' => false
            ])
            ->add('dejaPasse', CheckboxType::class,[
                'label' => 'Sortie passées',
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
