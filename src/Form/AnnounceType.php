<?php

namespace App\Form;

use App\Entity\Announce;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AnnounceType extends AbstractType
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null,[
                'label'=> 'Titre',
                'attr'=>[
                    'placeholder' => 'Titre',
                ]
            ])
            ->add('content', TextareaType::class,[
                'label'=>'Contenu'
            ])
            -> add ('imageFile' , VichImageType ::class, [
                'required' => false ,
                'allow_delete' => true ,
                'delete_label' => 'Supprimer l\'image' ,
                'download_label' => true,
                'download_uri' => true ,
                'image_uri' => true ,
               'asset_helper' => true,
            ])
           ->add('category', EntityType::class,[
                'class'=>Category::class,
                'required'=>true,
                'choice_label'=>'name',
                'multiple'=>true,
                'label'=>'Catégories',
                'placeholder'=>'Catégories',
                'attr'=>[
                    'class'=>'text-center mx-auto'
                ]
           ])
           ->add('submit', SubmitType::class,[
            'label'=>'Envoyer',
            'attr'=>[
                'class'=>'btn btn-secondary mb-3 mx-auto'
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
