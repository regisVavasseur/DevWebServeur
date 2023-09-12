<?php

use pizzashop\shop\domain\dto\order\OrderDTO;

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




}