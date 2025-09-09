<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Categorie;
use App\Form\EquipementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipementController extends AbstractController
{
    #[Route('/equipement/new', name: 'equipement_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
        $categories = $entityManager->getRepository(Categorie::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipement);
            $entityManager->flush();
            $this->addFlash('success', 'Équipement enregistré avec succès !');
            return $this->redirectToRoute('user_dashboard');
        }

        return $this->render('equipement/new.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }

    #[Route('/equipements', name: 'equipement_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $equipements = $em->getRepository(Equipement::class)->findAll();
        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('equipement/index.html.twig', [
            'equipements' => $equipements,
            'categories' => $categories,
        ]);
    } 

    #[Route('/equipement/{id}/modifier', name: 'equipement_modifier')]
    public function edit(Request $request, Equipement $equipement, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Équipement modifié avec succès.');
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('admin_dashboard');
            }
            return $this->redirectToRoute('user_dashboard');
        }

        return $this->render('equipement/modifier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/equipement/{id}/delete', name: 'equipement_delete', methods: ['POST'])]
    public function delete(Request $request, Equipement $equipement, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipement->getId(), $request->request->get('_token'))) {
            $em->remove($equipement);
            $em->flush();
            $this->addFlash('success', 'Équipement supprimé avec succès.');
        }
        return $this->redirectToRoute('user_dashboard');
    }
}
