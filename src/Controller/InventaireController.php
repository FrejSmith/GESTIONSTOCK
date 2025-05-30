<?php

namespace App\Controller;

use App\Entity\TransactionInventaire;
use App\Form\TransactionInventaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventaireController extends AbstractController
{
    #[Route('/inventaire', name: 'inventaire_index')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transaction = new TransactionInventaire();
        $form = $this->createForm(TransactionInventaireType::class, $transaction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transaction);
            $entityManager->flush();

            $this->addFlash('success', 'Transaction enregistrée avec succès !');

            return $this->redirectToRoute('inventaire_index');
        }

        $transactions = $entityManager->getRepository(TransactionInventaire::class)->findAll();

        return $this->render('inventaire/index.html.twig', [
            'form' => $form->createView(),
            'transactions' => $transactions,
        ]);
    }
}