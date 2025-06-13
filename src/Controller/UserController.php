<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\TransactionInventaire;
use App\Form\TransactionInventaireType; // <-- N'oublie pas d'importer le formulaire
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // <-- Pour gérer le formulaire
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
        $equipements = $entityManager->getRepository(Equipement::class)->findAll();

        return $this->render('user/catalogue.html.twig', [
            'equipements' => $equipements,
        ]);
    }

    #[Route('/user/profile', name: 'user_profile')]
    public function profile(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        // Récupérer toutes les transactions de l'utilisateur connecté
        $transactions = $entityManager->getRepository(TransactionInventaire::class)
            ->findBy(['user' => $user], ['Date' => 'DESC']);

        // Calculer le total des quantités
        $total = 0;
        foreach ($transactions as $t) {
            $total += $t->getQuantite();
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'transactions' => $transactions,
            'total' => $total,
        ]);
    }

    #[Route('/user/inventaire/ajout', name: 'user_inventaire_ajout')]
    public function ajoutInventaire(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $transaction = new TransactionInventaire();
        $transaction->setUser($user);

        $form = $this->createForm(TransactionInventaireType::class, $transaction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transaction);
            $entityManager->flush();

            $this->addFlash('success', 'Équipement ajouté à votre inventaire !');
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/ajout_inventaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
