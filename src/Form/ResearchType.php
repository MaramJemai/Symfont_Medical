<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Insurance;
use App\Entity\Speciality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class ResearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('governorate' , ChoiceType::class, [
            'choices'  => [
                'choose a governorate' => null,
                'Bizerte' => 'Bizerte',
                'Sousse' => 'Sousse',
                'Ariana' => 'Bizerte',
                'Jandouba' => 'Bizerte',
                'Gabes' => 'Bizerte',
                'Gafsa' => 'Bizerte',
                'Touzer' => 'Bizerte',
                'Mednin' => 'Bizerte',
                'Tatawin' => 'Bizerte',
                'kairawen' => 'Bizerte',
                'Mahdia' => 'Bizerte',
                'Monastir' => 'Bizerte',
                'Sfax' => 'Bizerte',
                'Tunis' => 'Bizerte',
                'Beja' => 'Bizerte',
                'Nabeul' => 'Bizerte',
                'Manouba' => 'Bizerte',
                'Selyena' => 'Bizerte',
                'Bizerte' => 'Bizerte',
                'Bizerte' => 'Bizerte',
                'Bizerte' => 'Bizerte',
                'Bizerte' => 'Bizerte',
                'Bizerte' => 'Bizerte',
                'Bizerte' => 'Bizerte',
            ]
            , 'label' => false  
            ])
            ->add('consult_fees', NumberType::class, [
                 'label' => false  
            ])
            ->add('insurance', EntityType::class, [
                'class' => Insurance::class,
                'choice_label' => 'name'
                , 'label' => false  
            ])
        ->add('speciality', EntityType::class, [
               'class'    => Speciality::class,
                 'choice_label' => 'name'
                 , 'label' => false  
                     ])  
        ->add('Search',SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}