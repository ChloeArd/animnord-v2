<?php

namespace App\Form;

use App\Entity\AdLost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdLostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('animal', ChoiceType::class, [
                'label' => 'Animal :',
                'choices' => [
                    'Mâle' => 'Mâle',
                    'Femelle' => 'Femelle'
                ],
                'multiple' => false,
                'expanded' => true
            ])
            ->add('name', TextType::class, ['label' => "Nom :"])
            ->add('sex', ChoiceType::class, [
                    'label' => 'Sexe :',
                    'choices' => [
                        'Chien' => 'Chien',
                        'Chat' => 'Chat'
                    ],
                    'multiple' => false,
                    'expanded' => true
            ])
            ->add('size', ChoiceType::class, [
                'label' => 'Taille :',
                'choices' => [
                    'Très petite' => 'Très petite',
                    'Petite' => 'Petite',
                    'Moyenne' => 'Moyenne',
                    'Grande' => 'Grande',
                    'Très grande' => 'Très grande'
                ]
            ])
            ->add('fur', ChoiceType::class, [
                'label' => 'Poils :',
                'choices' => [
                    'Nu' => 'Nu',
                    'Courts' => 'Courts',
                    'Mi-longs' => 'Mi-longs',
                    'Longs' => 'Longs',
                    'Bouclés' => 'Bouclés'
                ]
            ])
            ->add('color', ChoiceType::class, [
                'label' => 'Couleur(s) :',
                'choices' => [
                    'Noir' => 'Noir',
                    'Blanc' => 'Blanc',
                    'Marron' => 'Marron',
                    'Gris' => 'Gris',
                    'Beige' => 'Beige',
                    'Roux' => 'Roux'
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('dress', ChoiceType::class, [
                'label' => 'Robe :',
                'choices' => [
                    'Unie' => 'Unie',
                    'Tachetée' => 'Tachetée',
                    'Rayée' => 'Rayée',
                    'Bringée' => 'Bringée',
                    'Colourpointe' => 'Colourpointe',
                    'Bicolore' => 'Bicolore',
                    'Tricolore' => 'Tricolore',
                    'Pluricolore' => 'Pluricolore'
                ]
            ])
            ->add('race', TextType::class, [
                'label' => 'Race :',
                'placeholder' => 'Ex: berger allemand'
            ])
            ->add('number', TextType::class, [
                'label' => 'Numéro du tatouage ou de la puce :',
                'placeholder' => "Ex : 123ABC"
            ])
            ->add('description')
            ->add('date_lost')
            ->add('date')
            ->add('city')
            ->add('picture')
            ->add('user_fk')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdLost::class,
        ]);
    }
}
