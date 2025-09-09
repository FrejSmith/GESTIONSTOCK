<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TransactionInventaire;
use App\Entity\Equipement;

class UserDashboardController extends AbstractController
{
    #[Route('/espace-client', name: 'user_dashboard')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
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

        $transactions = $entityManager->getRepository(TransactionInventaire::class)
            ->findBy(['user' => $user], ['date' => 'DESC'], 5);

        $totalProduits = count($equipements);
        $enStock = count(array_filter($equipements, fn($e) => $e->getStock() > 0));
        $stockFaible = count(array_filter($equipements, fn($e) => $e->getStock() < 5 && $e->getStock() > 0));
        $rupture = count(array_filter($equipements, fn($e) => $e->getStock() == 0));

        return $this->render('user/dashboard.html.twig', [
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