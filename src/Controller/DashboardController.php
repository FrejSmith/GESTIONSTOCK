<?php

namespace App\Controller;

use App\Entity\Equipement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin', name: 'admin_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $totalEquipements = $entityManager->getRepository(Equipement::class)->count([]);
        $equipementsRupture = 0; // Remplacez par la logique appropriée
        $totalCategories = 0; // Remplacez par la logique appropriée
        $totalTransactions = 0; // Remplacez par la logique appropriée
        $lastTransactions = []; // Remplacez par la logique appropriée

        return $this->render('admin/dashboard.html.twig', [
            'totalEquipements' => $totalEquipements,
            'equipementsRupture' => $equipementsRupture,
            'totalCategories' => $totalCategories,
            'totalTransactions' => $totalTransactions,
            'lastTransactions' => $lastTransactions, // tableau de transactions récentes
        ]);
    }
}