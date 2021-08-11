<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, [
                'label' => 'Email',
                'required' => true,
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('nom', null, [
                'label' => 'Nom',
                'required' => true,
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('prenom', null, [
                'label' => 'Prénom',
                'required' => true,
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('telephone', null, [
                'label' => 'Téléphone',
                'required' => true,
                'attr' =>[
                    'class' => 'form-control']
            ])
            ->add('campus', EntityType::class,[
                'class' => Campus::class,
                'choice_label' => 'nom',
                'attr' =>[
                    'class' => 'form-select']
            ])

            ->add('photoProfil', FileType::class, [
                'label' => 'Photo de profil',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,


                'attr' =>[
                    'class' => 'form-control'],
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'Merci d\'envoyer un fichier image valide',
                    ])
                ],
            ])
            ->add('Valider', SubmitType::class,[
                'attr' =>[
                    'class' => 'btn']

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
