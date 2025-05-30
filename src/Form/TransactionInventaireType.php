<?php

namespace App\Form;

use App\Entity\TransactionInventaire;
use App\Entity\Equipement;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionInventaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Type', TextType::class)
            ->add('quantite', IntegerType::class)
            ->add('Date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('equipement', EntityType::class, [
                'class' => Equipement::class,
                'choice_label' => 'name', // Assurez-vous que "name" est une propriété valide dans l'entité Equipement
                'placeholder' => 'Sélectionnez un équipement', // Ajoutez un placeholder pour éviter une valeur null
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nom', // Assurez-vous que "username" est une propriété valide dans l'entité Utilisateur
                'placeholder' => 'Sélectionnez un utilisateur', // Ajoutez un placeholder pour éviter une valeur null
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TransactionInventaire::class,
        ]);
    }
}