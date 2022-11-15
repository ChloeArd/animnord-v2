<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => "Nom",
            ])
            ->add('firstname', TextType::class, [
                'label' => "Prénom"
            ])
            ->add('email', EmailType::class, [
                "label" => "Adresse E-mail",
                "constraints" => [
                    new NotBlank([
                        "message" => "L'email ne peut pas être vide"
                    ]),
                    new Email([
                        'message' => "L'email n'est pas valide",
                        'mode' => 'html5'
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => "L'email n'est pas assez longue"
                    ])
            ]])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "J'accepte les conditions",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe',
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Votre mot de passe'
                ],
                'second_options' => [
                    'label' => 'Répetez votre mot de passe'
                ],
                "invalid_message" => "Votre mot de passe n'est pas valide",
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe ne peut pas être vide',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, ["label" => "Créer mon compte"])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
