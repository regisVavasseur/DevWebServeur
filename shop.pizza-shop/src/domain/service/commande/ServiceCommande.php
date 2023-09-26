<?php

namespace pizzashop\shop\domain\service\commande;

use iInfoProduit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Monolog\Logger;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\commande\ItemDTO;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\Item;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use ServiceCommandeInvalidException;
use ServiceCommandeNotFoundException;

class ServiceCommande implements iCommander
{

    private iInfoProduit $iInfoProduit;
    private LoggerInterface $logger;

    public function __construct(iInfoProduit $serviceinfoProduit, LoggerInterface $logger)
    {
        $this->iInfoProduit = $serviceinfoProduit;
        $this->logger = $logger;
    }

    public function creerCommande(CommandeDTO $commandeDTO): CommandeDTO
    {
        //exercice 4 - Validation infos commande

        $emailClient = $commandeDTO->getMailClient();
        $typeLivraison = $commandeDTO->getTypeLivraison();
        $arrayItems = $commandeDTO->getItemsDTO();

        //• email présent et valide

        if (!filter_var($emailClient, FILTER_VALIDATE_EMAIL)) {
            throw new ServiceCommandeInvalidException();
        }

        //• type_livraison présent et valeur conforme (liste),

        if (!in_array($typeLivraison, [Commande::LIVRAISON_SUR_PLACE, Commande::LIVRAISON_A_EMPORTER, Commande::LIVRAISON_A_DOMICILE])) {
            throw new ServiceCommandeInvalidException();
        }

        //• tableau d'items présent et non vide,

        if (empty($arrayItems)) {
            throw new ServiceCommandeInvalidException();
        }

        //• pour chaque item :
            //◦ numéro, quantité : présents, valeurs entières positives
            //◦ taille : présent, valeur conforme (liste)

        foreach ($arrayItems as $item) {
            // Validation des champs obligatoires
            if (empty($item->getNumero()) || empty($item->getQuantite()) || empty($item->getTaille())) {
                throw new ServiceCommandeInvalidException();
            }
            // Validation des valeurs entières positives
            if (!is_int($item->getQuantite()) || $item->getQuantite() < 0) {
                throw new ServiceCommandeInvalidException();
            }
            if (!is_int($item->getNumero()) || $item->getNumero() < 0) {
                throw new ServiceCommandeInvalidException();
            }
            // Validation de la taille de l'item | Constantes dans Produit.php
            if (!in_array($item->getTaille(), [Produit::TAILLE_NORMALE, Produit::TAILLE_GRANDE])) {
                throw new ServiceCommandeInvalidException();
            }
        }

        //fin exo4

        $commande = new Commande();
        $commande->id = Uuid::uuid4()->toString();
        $commande->idClient = $emailClient;
        $commande->date_commande = date("Y-m-d H:i:s");
        $commande->type_livraison = $typeLivraison;
        $commande->etat = $commande::ETAT_CREE;
        $commande->delai = 0;

        $total_price = 0;

        foreach ($arrayItems as $item) {
            $total_price += ($item->getPrix() * $item->getQuantite());

            $this->creerItem($item);
        }

        $commande->montant_total = $total_price;
        $commandeDTO->setMontant($total_price);

        $commande->save();

        $this->logger->info('CommandeServiceLogger: CommandeService: Commande créée');

        return $commande->toDTO();

    }

    public function creerItem(ItemDTO $itemDTO) {
        $item = new Item();

        $item->numero = $itemDTO->getNumero();
        $item->taille = $itemDTO->getTaille();
        $item->quantite = $itemDTO->getQuantite();

        $item->save();
    }

    public function accederCommande(string $idCommande): CommandeDTO
    {
        try {
            $commande = Commande::findOrFail($idCommande);
        } catch (ModelNotFoundException $e) {
            throw new ServiceCommandeNotFoundException($e);
        }
        // $commande
        return $commande->toDTO();
    }

    public function validerCommande(string $idCommande): CommandeDTO
    {
        try {
            $commande = Commande::find($idCommande);
        } catch (ModelNotFoundException $e) {
            throw new ServiceCommandeInvalidException();
        }
        if ($commande->etat > Commande::ETAT_VALIDE) {
            throw new ServiceCommandeInvalidException();
        }
        $commande->update(['etat' => Commande::ETAT_VALIDE]);
        //logger
        $commande->save();

        $this->logger->info('CommandeServiceLogger: CommandeService: Commande validée');

        return $commande->toDTO();
    }
}