<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ['label' => "Prénom"])
            ->add('lastname', TextType::class, ['label' => "Nom"])
            ->add('email',EmailType::class, [
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
                ]
            ])
            ->add('phone', TelType::class, ['label' => 'Téléphone'])
            ->add('roles', CollectionType::class, ['label' => 'My roles'])
            ->add('password', TextType::class, ['label' => 'My password'])
            ->add('isVerified', RadioType::class, ['label' => 'IsVerified'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
