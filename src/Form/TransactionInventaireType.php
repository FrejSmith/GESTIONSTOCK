<?php
// src/Form/TransactionInventaireType.php
namespace App\Form;

use App\Entity\TransactionInventaire;
use App\Entity\Equipement;
use App\Entity\Categorie; // <-- Ajoute cet import
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionInventaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipement', EntityType::class, [
                'class' => Equipement::class,
                'choice_label' => 'nom',
                'label' => 'Équipement',
            ])
            // Champ catégorie ajouté ici
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'required' => true,
            ])
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Entrée' => 'Entrée',
                    'Sortie' => 'Sortie',
                ],
                'label' => 'Type de transaction',
            ])
            ->add('quantite', IntegerType::class, [
                'label' => 'Quantité',
            ])
            ->add('Date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TransactionInventaire::class,
        ]);
    }
}
