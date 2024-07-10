<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
        //     ->add('formateur', EntityType::class, [
        //         'class' => User::class,
        //         'choices' => $options['formateurs'],
        //         'choice_label' => function ($user) {
        //             return $user->getPrenom() . ' ' . $user->getNom();
        //         },
        //     ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
            // 'formateurs' => [],
        ]);
    }
}
