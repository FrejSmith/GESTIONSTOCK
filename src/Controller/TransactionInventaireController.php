<?php

namespace App\Controller;

use App\Entity\TransactionInventaire;
use App\Form\TransactionInventaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionInventaireController extends AbstractController
{
    #[Route('/inventaires', name: 'inventaire_index')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        // Création du formulaire
        $transaction = new TransactionInventaire();
        $form = $this->createForm(TransactionInventaireType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transaction->setUser($user);
            $entityManager->persist($transaction);
            $entityManager->flush();

            return $this->redirectToRoute('inventaire_index');
        }

        // Récupération des transactions selon le rôle
        if ($this->isGranted('ROLE_ADMIN')) {
            $transactions = $entityManager->getRepository(TransactionInventaire::class)->findAll();
        } else {
            $transactions = $entityManager->getRepository(TransactionInventaire::class)
                ->findBy(['user' => $user]);
        }

        return $this->render('inventaire/index.html.twig', [
            'form' => $form->createView(),
            'transactions' => $transactions,
        ]);
    }
}