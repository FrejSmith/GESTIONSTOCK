<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('public/home.html.twig');
    }

    #[Route('/caracteristiques', name: 'caracteristiques')]
    public function caracteristiques(): Response
    {
        return $this->render('public/caracteristiques.html.twig');
    }
#[Route('/tarification', name: 'tarification')]
public function tarification(): Response
{
    return $this->render('public/tarification.html.twig');
}
#[Route('/contact', name: 'contact')]
public function contact(Request $request): Response
{
    $success = false;
    $error = null;

    if ($request->isMethod('POST')) {
        $nom = trim($request->request->get('nom', ''));
        $email = trim($request->request->get('email', ''));
        $message = trim($request->request->get('message', ''));

        if (!$nom || !$email || !$message) {
            $error = "Tous les champs sont obligatoires.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "L'email n'est pas valide.";
        } else {
            // Ici tu pourrais envoyer un email ou enregistrer le message
            $success = true;
        }
    }

    return $this->render('public/contact.html.twig', [
        'success' => $success,
        'error' => $error,
    ]);
}
#[Route('/paiement/{offre}', name: 'paiement')]
public function paiement(Request $request, string $offre = null): Response
{
    // Tu peux adapter l'affichage selon l'offre choisie
    return $this->render('public/paiement.html.twig', [
        'offre' => $offre,
    ]);
}
#[Route('/paiement/paypal/{offre}', name: 'paypal_paiement')]
public function paypalPaiement(string $offre = null): Response
{
    // Ici tu peux afficher une page d'intégration PayPal ou une maquette
    return $this->render('public/paypal.html.twig', [
        'offre' => $offre,
    ]);
}
}