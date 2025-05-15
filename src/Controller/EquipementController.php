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
    #[Route('/equipements/new', name: 'equipement_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($equipement);
            $em->flush();

            return $this->redirectToRoute('equipement_index');
        }

        return $this->render('equipement/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
