<?php

use pizzashop\shop\domain\dto\commande\CommandeDTO;

interface iCommander
{

    public function creerCommande(CommandeDTO $commandeDTO): CommandeDTO;
    public function accederCommande(string $idCommande): CommandeDTO;
    public function validerCommande(string $idCommande): CommandeDTO;
}