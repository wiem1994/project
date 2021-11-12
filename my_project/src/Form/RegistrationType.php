<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\CallbackTransformer;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('nom', TextType::class, ['required'   => true])
            ->add('prenom', TextType::class, ['required'   => true])
            ->add('email', TextType::class, ['required'   => true])
            ->add('password', PasswordType::class, ['required'   => true])
            // ->add('roles', HiddenType::class, ['empty_data' => 'user'])
            ->add('roles', ChoiceType::class, [

                'choices' => [

                    'User ' => 'ROLE_USER',

                    'Administrator ' => 'ROLE_ADMIN'

                ],

                'expanded' => true,

                'multiple' => true,

                'label' => 'Roles',

                'empty_data' => ['ROLE_USER'],

            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
