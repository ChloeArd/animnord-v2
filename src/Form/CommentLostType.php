<?php

namespace App\Form;

use App\Entity\AdLost;
use App\Entity\CommentLost;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentLostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        date_default_timezone_set('Europe/Paris');
        $date = new \DateTime();

        $builder
            ->add('content', TextareaType::class, ['label' => 'Commentaire :'])
            ->add('date', DateTimeType::class, [
                'label' => "Date : ",
                'widget' => 'text',
                'data' => $date
            ])
            ->add('adLost_fk', EntityType::class, ['class' => AdLost::class, "choice_label" => "id"])
            ->add('user_fk', EntityType::class, ['class' => User::class, "choice_label" => "id"])
            ->add('archive', TextType::class)
            ->add('submit', SubmitType::class, ["label" => "Commenter"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommentLost::class,
        ]);
    }
}
