<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{   
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('email')
            ->add('password');
            if ($this->security->isGranted('ROLE_ADMIN')){
            $builder->add('roles');
            }
            $builder->add('Cours')

            
            ->add('Cours', EntityType::class,[
                'class'=>Cours::class,
                'choice_label'=>'titre',
                'multiple' => true,
                'expanded' => true,
            ]);
           

        // Conditionner l'ajout du champ utilisateur
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder->add('roles', ChoiceType::class, [
                'choices' => [
                'Formateur' => 'ROLE_FORMATEUR',
                'Etudiant' => 'ROLE_ETUDIANT',
            ],
            'multiple' => true,
            'expanded' => false,
        ]);
        }

      
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
