<?php

namespace App\Controller;

use App\Repository\TransactionInventaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventaireController extends AbstractController
{
    #[Route('/inventaire/export', name: 'inventaire_export')]
    public function export(TransactionInventaireRepository $transactionInventaireRepository): Response
    {
        $user = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
            $transactions = $transactionInventaireRepository->findAll();
        } else {
            $transactions = $transactionInventaireRepository->findBy(['user' => $user]);
        }

        $csv = "id;type;quantite;date;equipement;utilisateur\n";

        foreach ($transactions as $t) {
            $date = $t->getDate();
            // Format ISO et guillemets pour Excel
            $formattedDate = $date ? '"' . $date->format('Y-m-d H:i:s') . '"' : '""';

            $csv .= sprintf(
                "%d;%s;%d;%s;%s;%s\n",
                $t->getId(),
                $t->getType(),
                $t->getQuantite(),
                $formattedDate,
                $t->getEquipement()?->getName() ?? '',
                $t->getUser()?->getEmail() ?? ''
            );
        }

        return new Response(
            $csv,
            200,
            [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="transaction_inventaire.csv"',
            ]
        );
    }
}
