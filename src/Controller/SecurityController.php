<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security; // Correct namespace

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, redirigez-le
        if ($this->getUser()) {
            return $this->redirectToRoute('admin_dashboard');
        }

        // Récupérer les erreurs de connexion (s'il y en a)
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom d'utilisateur saisi
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Ce code ne sera jamais exécuté car Symfony gère la déconnexion automatiquement
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/redirect', name: 'app_redirect')]
    public function redirectAfterLogin(Security $security): Response
    {
        $user = $security->getUser();

        if ($user) {
            // Rediriger en fonction du rôle
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                return $this->redirectToRoute('admin_dashboard');
            } elseif (in_array('ROLE_USER', $user->getRoles())) {
                return $this->redirectToRoute('client_dashboard');
            }
        }

        // Si aucun rôle n'est trouvé, rediriger vers la page de connexion
        return $this->redirectToRoute('app_login');
    }
}