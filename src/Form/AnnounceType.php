<?php

namespace App\Form;

use App\Entity\Announce;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AnnounceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null,[
                'attr'=>[
                    'placholder' => 'Titre'
                ]
            ])
            ->add('content', TextareaType::class)
            -> add ('imageFile' , VichImageType ::class, [
                'required' => false ,
                'allow_delete' => true ,
                'delete_label' => 'Supprimer l\'image' ,
                'download_label' => true,
                'download_uri' => true ,
                'image_uri' => true ,
               'asset_helper' => true,
            ])
        //    ->add('category', EntityType::class,[
        //       'class'=>Category::class,
        //       'label'=>'Catégories',
        //       'expanded'=>true,
        //       'multiple'=>true,
        //       'choice_label'=>'name',
        //       'attr'=>[
        //           'class'=>'text-center mx-auto'
        //       ] 
        //    ])
           ->add('submit', SubmitType::class,[
            'label'=>'Envoyer',
            'attr'=>[
                'class'=>'btn btn-secondary mb-3'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Announce::class,
        ]);
    }
}
