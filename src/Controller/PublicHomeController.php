<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicHomeController extends AbstractController
{
    #[Route('/', name: 'homepage_public')]
    public function accueil(): Response
    {
        return $this->render('public/home.html.twig', [
            'message' => 'Bienvenue sur la page d\'accueil publique !',
        ]);
    }
}