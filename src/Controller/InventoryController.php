<?php
// filepath: /Users/macbookpro/GestionStock/src/Controller/InventoryController.php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends AbstractController
{
    #[Route('/inventory', name: 'inventory_list')]
    public function list(): Response
    {
        return $this->render('inventory/index.html.twig', [
            'title' => 'Ajouter un produit',
        ]);
    }

    /**
     * @Route("/inventory/save", name="inventory_save", methods={"POST"})
     */
    public function save(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données du formulaire
        $productName = $request->request->get('product_name');
        $quantity = $request->request->get('quantity');
        $price = $request->request->get('price');

        // Créer une nouvelle entité Product
        $product = new Product();
        $product->setName($productName);
        $product->setQuantity($quantity);
        $product->setPrice($price);

        // Enregistrer dans la base de données
        $entityManager->persist($product);
        $entityManager->flush();

        // Rediriger ou afficher un message de succès
        return $this->redirectToRoute('inventory_list'); // Remplacez par votre route principale
    }
}