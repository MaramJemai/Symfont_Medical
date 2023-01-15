<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Insurance;
use App\Entity\Speciality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('first_name' , TextType::class  , [ 'label' => false  ])
        ->add('last_name', TextType::class  , [ 'label' => false  ])
        ->add('governorate' , ChoiceType::class, [
            'choices'  => [
                'choose a governorate' => null,
                'Bizerte' => 'Bizerte',
                'Sousse' => 'Sousse',
                'Gbeli' => 'Gbeli',
                'Jandouba' => 'Jandouba',
                'Gabes' => 'Gabes',
                'Gafsa' => 'Gafsa',
                'Touzer' => 'Touzer',
                'Mednin' => 'Mednin',
                'Tatawin' => 'Tatawin',
                'kairawen' => 'kairawen',
                'Mahdia' => 'Ben',
                'Monastir' => 'Mahdia',
                'Sfax' => 'Sfax',
                'Tunis' => 'Tunis',
                'Beja' => 'Beja',
                'Nabeul' => 'Nabeul',
                'Manouba' => 'Manouba',
                'Selyena' => 'Selyena',
                'Ben Arous' => 'Ben Arous',
                'Zaghouen' => 'Zaghouen',
                'Gasrine' => 'Gasrine',
                'Sidi Bouzid' => 'Sidi Bouzid',
                'Keserine' => 'Keserine',
                'Djerba' => 'Djerba',

            ]
            , 'label' => false        ])
        ->add('consult_fees', NumberType::class  , [ 'label' => false  ])
        ->add('email', TextType::class  , [ 'label' => false  ])
        ->add('insurance', EntityType::class, [
                'class' => Insurance::class,
                'choice_label' => 'name'
                , 'label' => false  
            ])
        ->add('speciality', EntityType::class, [
               'class'    => Speciality::class,
                 'choice_label' => 'name'
                 , 'label' => false                ])            
        ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
                , 'label' => false  

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
