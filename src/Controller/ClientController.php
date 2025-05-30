<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client', name: 'client_')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        return $this->render('client/dashboard.html.twig', [
            'message' => 'Bienvenue dans l\'espace client',
        ]);
    }
}