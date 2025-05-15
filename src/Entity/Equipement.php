<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementRepository::class)]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column]
    private ?int $NumeroDeSerie = null;

    #[ORM\Column]
    private ?int $Quantité = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Statut = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $catégorie = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $fournisseur = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Emplacement $Emplacement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getNumeroDeSerie(): ?int
    {
        return $this->NumeroDeSerie;
    }

    public function setNumeroDeSerie(int $NumeroDeSerie): static
    {
        $this->NumeroDeSerie = $NumeroDeSerie;

        return $this;
    }

    public function getQuantité(): ?int
    {
        return $this->Quantité;
    }

    public function setQuantité(int $Quantité): static
    {
        $this->Quantité = $Quantité;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(?string $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getCatégorie(): ?Categorie
    {
        return $this->catégorie;
    }

    public function setCatégorie(Categorie $catégorie): static
    {
        $this->catégorie = $catégorie;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getEmplacement(): ?Emplacement
    {
        return $this->Emplacement;
    }

    public function setEmplacement(Emplacement $Emplacement): static
    {
        $this->Emplacement = $Emplacement;

        return $this;
    }
}
