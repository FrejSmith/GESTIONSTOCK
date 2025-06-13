<?php

namespace App\Controller;

use App\Entity\Equipement; // Utilisez l'entité Equipement
use App\Entity\User; // Import de l'entité User
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Form\EquipementType;

// #[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'message' => 'Bienvenue dans l\'espace admin',
        ]);
    }

    #[Route('/products', name: 'products')]
    public function manageProducts(): Response
    {
        return $this->render('admin/products.html.twig');
    }

    #[Route('/users', name: 'users')]
    public function manageUsers(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les user depuis la base de données
        $user = $entityManager->getRepository(User::class)->findAll();

        // Passer les user à la vue
        return $this->render('admin/users.html.twig', [
            'users' => $user, // Transmettez les utilisateurs à la vue
        ]);
    }

    #[Route('/equipements', name: 'equipements')]
    public function manageEquipements(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les équipements depuis la base de données
        $equipements = $entityManager->getRepository(Equipement::class)->findAll();

        // Passer les équipements à la vue
        return $this->render('admin/equipements.html.twig', [
            'equipements' => $equipements,
        ]);
    }

    #[Route('/equipements/ajouter', name: 'equipements_ajouter')]
    public function ajouterEquipement(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipement = new Equipement();

        // Créer le formulaire
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipement);
            $entityManager->flush();

            // Rediriger vers la liste des équipements
            return $this->redirectToRoute('admin_equipements');
        }

        // Afficher le formulaire
        return $this->render('admin/ajouter_equipement.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}