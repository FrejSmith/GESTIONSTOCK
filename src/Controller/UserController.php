<?php

namespace App\Controller;

use App\Entity\Equipement; // Import de l'entité Equipement
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
        return $this->render('user/homepage.html.twig');
    }

    #[Route('/catalogue', name: 'catalogue')]
    public function catalogue(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les équipements depuis la base de données
        $equipements = $entityManager->getRepository(Equipement::class)->findAll();

        // Passer les équipements à la vue
        return $this->render('user/catalogue.html.twig', [
            'equipements' => $equipements,
        ]);
    }
}