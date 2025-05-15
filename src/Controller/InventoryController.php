<?php
// filepath: /Users/macbookpro/GestionStock/src/Controller/InventoryController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends AbstractController
{
    #[Route('/inventory', name: 'inventory_list')]
    public function list(): Response
    {
        // Exemple de données d'inventaire
        $inventory = [
            ['id' => 1, 'name' => 'Produit A', 'quantity' => 10],
            ['id' => 2, 'name' => 'Produit B', 'quantity' => 5],
            ['id' => 3, 'name' => 'Produit C', 'quantity' => 20],
        ];

        return $this->render('inventory/list.html.twig', [
            'inventory' => $inventory,
        ]);
    }
}