<?php

namespace pizzashop\shop\domain\service\commande;

use iInfoProduit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Monolog\Logger;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\commande\ItemDTO;
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

    public function creerCommande(CommandeDTO $commandeDTO): void
    {
        //function validerCommandeDeCommande(CommandeDTO) exercice 4
        if ($commandeDTO->getMailClient() == null || filter_var($commandeDTO->getMailClient(),FILTER_VALIDATE_EMAIL) || $commandeDTO->getTypeLivraison() == null) {
            throw new ServiceCommandeInvalidException();
        } else {
            $emailClient = $commandeDTO->getMailClient();
            $typeLivraison = $commandeDTO->getTypeLivraison();
        }

        if ($commandeDTO->getItemsDTO() == null) {
            throw new ServiceCommandeInvalidException();
        }else {
            $arrayItems = $commandeDTO->getItemsDTO();
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

    public function validerCommande(string $idCommande): void
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
    }
}