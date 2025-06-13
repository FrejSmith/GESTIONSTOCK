<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Categorie;
use App\Form\EquipementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipementController extends AbstractController
{
    #[Route('/equipement/new', name: 'equipement_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);

        // Récupérer toutes les catégories pour la vue (utile si tu veux les afficher ou les utiliser dans le formulaire)
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipement);
            $entityManager->flush();

            $this->addFlash('success', 'Équipement enregistré avec succès !');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('equipement/new.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories, // Passe les catégories à la vue
        ]);
    }

    #[Route('/equipements', name: 'equipement_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $equipements = $em->getRepository(Equipement::class)->findAll();
        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('equipement/index.html.twig', [
            'equipements' => $equipements,
            'categories' => $categories, // Passe les catégories à la vue si besoin d'affichage ou de filtre
        ]);
    } 
}
