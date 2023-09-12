<?php

use pizzashop\shop\domain\dto\item\ItemDTO;
use pizzashop\shop\domain\dto\order\OrderDTO;
use Ramsey\Uuid\Uuid;

class CommandeService
{


    public function __construct(CommandeService $commandeService)
    {
        $this->commandeService = $commandeService;
    }

    public function readOrder($id_commande)
    {
        $orderDTO = OrderDTO::find($id_commande);
        if ($orderDTO == null) {
            throw new ServiceCommandeNotFoundException();
        }
        return $orderDTO;

    }

    public function validateOrder($id_commande)
    {

        $orderDTO = OrderDTO::find($id_commande);
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

    public function createOrder(OrderDTO $orderDTO) {

        $emailClient = $orderDTO->getMailClient();
        $typeLivraison = $orderDTO->getTypeLivraison();
        $arrayItems = $orderDTO->getItemsDTO();

        $order = new Commande();
        $order->id = Uuid::uuid4()->toString();
        $order->idClient = $emailClient;
        $order->date_commande = date("Y-m-d H:i:s");
        $order->type_livraison = $typeLivraison;
        $order->etat = 1;
        $order->delai = 0;

        $total_price = 0;

        foreach ($arrayItems as $item) {
           $total_price += ($item->getPrix() * $item->getQuantite());

           createItem($item);
        }

        $order->montant_total = $total_price;
        $orderDTO->setMontant($total_price);

        $order->save();

        return $orderDTO;
    }

    public function createItem(ItemDTO $itemDTO) {
        $item = new Item();

        $item->numero = $itemDTO->getNumero();
        $item->taille = $itemDTO->getTaille();
        $item->quantite = $itemDTO->getQuantite();

        $item->save();
    }

}