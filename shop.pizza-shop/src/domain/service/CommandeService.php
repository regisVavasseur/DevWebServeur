<?php

use pizzashop\shop\domain\dto\order\OrderDTO;

class CommandeService
{

    public function readOrder($id_commande)
    {
        /*
        $orderDTO = OrderDTO::find($id_commande);
        if ($orderDTO == null) {
            throw new ServiceCommandeNotFoundException();
        }
        return $orderDTO;
        */
    }

    public function validateOrder($id_commande)
    {
        /*
        $orderDTO = OrderDTO::find($id_commande);
        if ($orderDTO == null) {
            throw new ServiceCommandeNotFoundException();
        }
        $orderDTO->etat = 2;
        $orderDTO->save();
        */
    }

    public function createOrder(OrderDTO $orderDTO) {

        return $orderDTO;
    }




}