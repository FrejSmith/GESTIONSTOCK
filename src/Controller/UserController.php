<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\TransactionInventaire;
use App\Form\TransactionInventaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        $transactions = $entityManager->getRepository(TransactionInventaire::class)
            ->findBy(['user' => $user], ['date' => 'DESC']);

        // Récupérer la catégorie du premier inventaire (si besoin)
        $categorie = null;
        if (count($transactions) > 0 && $transactions[0]->getEquipement()) {
            $categorie = $transactions[0]->getEquipement()->getCategorie();
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'transactions' => $transactions,
            'total' => array_sum(array_map(fn($t) => $t->getQuantite(), $transactions)),
            'categorie' => $categorie,
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
