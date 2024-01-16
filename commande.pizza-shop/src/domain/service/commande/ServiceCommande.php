<?php

namespace pizzashop\shop\domain\service\commande;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\Item;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;


class ServiceCommande implements iCommander
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @throws ServiceCommandeInvalidException
     */
    public function creerCommande(CommandeDTO $commandeDTO): CommandeDTO
    {
        //exercice 4 - Validation infos commande
        $emailClient = $commandeDTO->getMailClient();
        $typeLivraison = $commandeDTO->getTypeLivraison();
        $delai = $commandeDTO->getDelai();
        $arrayItems = $commandeDTO->getItemsDTO();

        //• email présent et valide
        if (!filter_var($emailClient, FILTER_VALIDATE_EMAIL)) {
            print "email invalide: (" . $emailClient . ")";
            throw new ServiceCommandeInvalidException();
        }

        //• type_livraison présent et valeur conforme (liste),
        if (!in_array($typeLivraison, [Commande::LIVRAISON_SUR_PLACE, Commande::LIVRAISON_A_EMPORTER, Commande::LIVRAISON_A_DOMICILE])) {
            throw new ServiceCommandeInvalidException();
        }

        //• delai présent et valeur conforme supérieur à 0,
        if (!is_int($delai) || $delai > 0) {
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
            if (!in_array($item->getTaille(), [1, 2])) {
                throw new ServiceCommandeInvalidException();
            }
        }

        //fin exo4

        $commande = new Commande();
        $commande->id = Uuid::uuid4()->toString();
        $commande->mail_client = $emailClient;
        $commande->date_commande = date("Y-m-d H:i:s");
        $commande->type_livraison = $typeLivraison;
        $commande->etat = $commandeDTO->getEtat();
        $commande->delai = $delai;

        foreach ($arrayItems as $itemDTO) {

            $item = new Item();
            $item->numero = $itemDTO->getNumero();
            $item->quantite = $itemDTO->getQuantite();
            $item->taille = $itemDTO->getTaille();
            $item->libelle_taille = $itemDTO->getLibelleTaille();
            $item->libelle = $itemDTO->getLibelle();
            $item->tarif = $itemDTO->getTarif();

            $commande->items()->save($item);
        }

        $commande->calculerMontantTotal();
        $commande->save();

        $this->logger->info('CommandeServiceLogger: CommandeService: Commande créée');

        return $commande->toDTO();

    }

    public function accederCommande(string $idCommande, string $email): CommandeDTO
    {
        try {
            return Commande::where('id', $idCommande)->where('mail_client', $email)->firstOrFail()
                ->toDTO();

        } catch (ModelNotFoundException $e) {
            throw new ServiceCommandeNotFoundException("Commande inexistante");
        }
    }

    public function validerCommande(string $idCommande, string $email): CommandeDTO
    {
        try {
            $commande = Commande::where('id', $idCommande)->where('mail_client', $email)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ServiceCommandeInvalidException("Commande inexistante",404);
        }

        if ($commande->etat >= Commande::ETAT_VALIDE) {
            throw new ServiceCommandeInvalidException("Commande déjà validée",400);
        }

        $commande->etat = Commande::ETAT_VALIDE;
        $commande->save();

        $this->logger->info('CommandeServiceLogger: CommandeService: Commande validée');

        return $commande->toDTO();
    }
}