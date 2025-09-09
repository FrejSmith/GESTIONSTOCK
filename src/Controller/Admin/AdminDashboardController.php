<?php

namespace App\Controller\Admin;

use App\Entity\Equipement;
use App\Entity\TransactionInventaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $search = $request->query->get('search');
        $equipementRepo = $entityManager->getRepository(Equipement::class);

        if ($search) {
            $equipements = $equipementRepo->createQueryBuilder('e')
                ->where('LOWER(e.name) LIKE :search')
                ->setParameter('search', '%' . strtolower($search) . '%')
                ->getQuery()
                ->getResult();
        } else {
            $equipements = $equipementRepo->findAll();
        }

        // Statistiques dynamiques
        $totalProduits = count($equipements);
        $enStock = count(array_filter($equipements, fn($e) => $e->getStock() > 0));
        $stockFaible = count(array_filter($equipements, fn($e) => $e->getStock() < 5 && $e->getStock() > 0));
        $rupture = count(array_filter($equipements, fn($e) => $e->getStock() == 0));

        // Toutes les transactions (entrées/sorties)
        $transactions = $entityManager->getRepository(TransactionInventaire::class)
            ->findBy([], ['date' => 'DESC']); // retire la limite pour tout afficher

        return $this->render('admin/transactionInventaire/dashboard.html.twig', [
            'totalProduits' => $totalProduits,
            'enStock' => $enStock,
            'stockFaible' => $stockFaible,
            'rupture' => $rupture,
            'transactions' => $transactions,
            'equipements' => $equipements,
            'search' => $search,
        ]);
    }
}