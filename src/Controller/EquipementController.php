<?php // <- **Obligatoire** pour que VS Code reconnaisse le langage PHP

namespace App\Controller;

use App\Entity\Equipement;
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

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipement);
            $entityManager->flush();

            $this->addFlash('success', 'Équipement enregistré avec succès !');

            return $this->redirectToRoute('homepage'); // Redirige vers la page d'accueil
        }

        return $this->render('equipement/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/equipements', name: 'equipement_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $equipements = $em->getRepository(Equipement::class)->findAll();

        return $this->render('equipement/index.html.twig', [
            'equipements' => $equipements,
        ]);
    }
}
