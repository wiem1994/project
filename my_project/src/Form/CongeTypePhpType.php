<?php

namespace App\Form;

use App\Entity\Conge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CongeTypePhpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iduser', IntegerType::class)
            ->add('datedebut', DateType::class, ['required'   => true, 'label' => 'Date de début de votre congé', 'widget' => 'single_text', 'years' => range(2021, 2022)])
            ->add('nombrejour', IntegerType::class, ['required'   => true, 'label' => 'Nombre de jour'])
            ->add('statut', ChoiceType::class, [

                'choices' => [

                    'En cours' => 'en cours',

                    'Validée' => 'validée ',

                    'refusée' => 'refusée'
                ],

                'expanded' => true,

                'multiple' => true,

                'label' => 'Statut de la demande',

                'data' => ['en cours']

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conge::class,
        ]);
    }
}
