<?php
namespace App\Form;

use App\Entity\Equipement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorie;

class EquipementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $builder
    ->add('name', TextType::class, [
        'label' => 'Nom de l\'équipement',
    ])
    ->add('categorie', EntityType::class, [
        'class' => Categorie::class,
        'choice_label' => 'nom',
        'label' => 'Catégorie',
        'placeholder' => 'Sélectionnez une catégorie',
        'required' => true,
    ])
    ->add('price', NumberType::class, [
        'label' => 'Prix',
    ])
    ->add('stock', NumberType::class, [
        'label' => 'Stock',
    ])
    ->add('description', TextareaType::class, [
        'label' => 'Description',
        'required' => false,
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipement::class,
        ]);
    }
}