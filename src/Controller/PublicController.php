<?php

namespace App\Controller;

use App\Entity\Equipement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/public', name: 'public_')]
class PublicController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('public/home.html.twig', [
            'message' => 'Bienvenue sur notre site de gestion de stock et inventaire',
        ]);
    }

    #[Route('/equipements', name: 'equipements')]
    public function equipements(EntityManagerInterface $entityManager): Response
    {
        $equipements = $entityManager->getRepository(Equipement::class)->findAll();

        return $this->render('public/equipements.html.twig', [
            'equipements' => $equipements,
        ]);
    }
}