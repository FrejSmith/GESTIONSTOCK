<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        // Exemple de données pour les statistiques
        $stats = [
            'total_items' => 120,
            'low_stock_alerts' => 5,
            'total_categories' => 10,
        ];

        return $this->render('admin/dashboard.html.twig', [
            'stats' => $stats, // Passez la variable "stats" au template
        ]);
    }
}