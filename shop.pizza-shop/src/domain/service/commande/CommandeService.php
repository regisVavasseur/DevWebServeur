<?php

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\item\ItemDTO;
use Ramsey\Uuid\Uuid;

class CommandeService implements iCommander
{

    private iInfoProduit $iInfoProduit;

    public function __construct(iInfoProduit $serviceinfoProduit)
    {
        $this->iInfoProduit = $serviceinfoProduit;
        //logger
    }
    

    public function creerCommande(CommandeDTO $commandeDTO): CommandeDTO
    {
        $emailClient = $orderDTO->getMailClient();
        $typeLivraison = $orderDTO->getTypeLivraison();
        $arrayItems = $orderDTO->getItemsDTO();

        $order = new Commande();
        $order->id = Uuid::uuid4()->toString();
        $order->idClient = $emailClient;
        $order->date_commande = date("Y-m-d H:i:s");
        $order->type_livraison = $typeLivraison;
        $order->etat = $order::ETAT_CREE;
        $order->delai = 0;

        $total_price = 0;

        foreach ($arrayItems as $item) {
            $total_price += ($item->getPrix() * $item->getQuantite());

            $this->creerItem($item);
        }

        $order->montant_total = $total_price;
        $orderDTO->setMontant($total_price);

        $order->save();

        return $orderDTO;    
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
        // utilisation de try / catch ?
        $orderDTO = CommandeDTO::findOrFail($idCommande);
        if ($orderDTO == null) {
            throw new ServiceCommandeNotFoundException();
        }
        // $order
        return $orderDTO;
    }

    public function validerCommande(string $idCommande): CommandeDTO
    {
        $orderDTO = CommandeDTO::find($idCommande);
        if ($orderDTO == null) {
            throw new ServiceCommandeNotFoundException();
        }
        if ($orderDTO->etat != 1) {
            throw new ServiceCommandeInvalidException();
        }
        $orderDTO->etat = 2;
        $orderDTO->save();
        return $orderDTO;
    }
}