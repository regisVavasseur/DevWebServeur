<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

interface iCommander
{

    public function creerCommande(CommandeDTO $commandeDTO): void;
    public function accederCommande(string $idCommande): CommandeDTO;
    public function validerCommande(string $idCommande): void;
}