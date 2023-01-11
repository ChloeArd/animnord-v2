<?php

namespace App\Form;

use App\Entity\AdLost;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AdLostType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        date_default_timezone_set('Europe/Paris');
        $date = new \DateTime();

        $builder
            ->add('animal', ChoiceType::class, [
                'label' => 'Animal : *',
                'choices' => [
                    'Chien' => 'Chien',
                    'Chat' => 'Chat'
                ],
                'multiple' => false,
                'expanded' => true
            ])
            ->add('name', TextType::class, ['label' => "Nom : *"])
            ->add('sex', ChoiceType::class, [
                    'label' => 'Sexe : *',
                    'choices' => [
                        'Mâle' => 'Mâle',
                        'Femelle' => 'Femelle',
                        'Inconnu' => 'Inconnu'
                    ],
                    'multiple' => false,
                    'expanded' => true
            ])
            ->add('size', ChoiceType::class, [
                'label' => 'Taille : *',
                'choices' => [
                    'Très petite' => 'Très petite',
                    'Petite' => 'Petite',
                    'Moyenne' => 'Moyenne',
                    'Grande' => 'Grande',
                    'Très grande' => 'Très grande'
                ]
            ])
            ->add('fur', ChoiceType::class, [
                'label' => 'Poils : *',
                'choices' => [
                    'Nu' => 'Nu',
                    'Courts' => 'Courts',
                    'Mi-longs' => 'Mi-longs',
                    'Longs' => 'Longs',
                    'Bouclés' => 'Bouclés'
                ]
            ])
            ->add('color', ChoiceType::class, [
                'label' => 'Couleur(s) du pelage : *',
                'choices' => [
                    'Noir' => 'Noir',
                    'Blanc' => 'Blanc',
                    'Marron' => 'Marron',
                    'Gris' => 'Gris',
                    'Beige' => 'Beige',
                    'Roux' => 'Roux'
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => true,
            ])
            ->add('dress', ChoiceType::class, [
                'label' => 'Robe : *',
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
                'label' => 'Race : *',
                'attr' => ['placeholder' => 'Ex: berger allemand'],
            ])
            ->add('number', TextType::class, [
                'label' => 'Numéro du tatouage ou de la puce :',
                'attr' => ['placeholder' => "Ex : 123ABC"],
                'required' => false
            ])
            ->add('description', TextareaType::class, ['label' => 'Description : *'])
            ->add('date_lost', DateType::class, [
                'label' => "Perdu le : *",
                'widget' => 'single_text'
            ])
            ->add('date', DateTimeType::class, [
                'label' => "Date : ",
                'widget' => 'text',
                'data' => $date
            ])
            ->add('city', TextType::class, ['label' => 'Ville : *'])
            ->add('picture', FileType::class, [
                'data_class' => null,
                'label' => 'Sélectionner une image à télécharger :',
                'constraints' => [
                    new File([
                        'mimeTypes' => ["image/*"],
                        'mimeTypesMessage' => 'Veuillez télécharger un document de type image valide !',
                    ])
                ],
                "required" => false
            ])
            ->add('user_fk', EntityType::class, ['class' => User::class, "choice_label" => "id"])
            ->add('submit', SubmitType::class, ["label" => "Publier"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdLost::class,
        ]);
    }
}
