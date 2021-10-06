<?php

namespace App\Form;

use App\Entity\Classroom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassroomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('grade', ChoiceType::class,[
                'choices'=>[
                    '6 ème'=>'6',
                    '5 ème'=>'5',
                    '4 ème'=>'4',
                    '3 ème'=>'3',
                ],
                'placeholder'=>'Classe'
            ])
            ->add('letter')
            // ->add('teachers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Classroom::class,
        ]);
    }
}
