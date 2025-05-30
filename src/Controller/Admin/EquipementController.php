<?php

namespace App\Controller\Admin;

use App\Entity\Equipement;
use App\Form\EquipementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/equipements', name: 'admin_equipements_')]
class EquipementController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $equipements = $entityManager->getRepository(Equipement::class)->findAll();

        return $this->render('admin/equipements/index.html.twig', [
            'equipements' => $equipements,
        ]);
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipement);
            $entityManager->flush();

            return $this->redirectToRoute('admin_equipements_index');
        }

        return $this->render('admin/equipements/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/modifier', name: 'modifier')]
    public function modifier(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipement = $entityManager->getRepository(Equipement::class)->find($id);

        if (!$equipement) {
            throw $this->createNotFoundException('Équipement non trouvé.');
        }

        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_equipements_index');
        }

        return $this->render('admin/equipements/modifier.html.twig', [
            'form' => $form->createView(),
            'equipement' => $equipement,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'supprimer', methods: ['POST'])]
    public function supprimer(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipement = $entityManager->getRepository(Equipement::class)->find($id);

        if (!$equipement) {
            throw $this->createNotFoundException('Équipement non trouvé.');
        }

        if (!$this->isCsrfTokenValid('delete' . $equipement->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Action non autorisée.');
        }

        $entityManager->remove($equipement);
        $entityManager->flush();

        $this->addFlash('success', 'Équipement supprimé avec succès.');

        return $this->redirectToRoute('admin_equipements_index');
    }
}