<?php

namespace pizzashop\shop\domain\service\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

interface iCommander
{

    public function creerCommande(CommandeDTO $commandeDTO): CommandeDTO;
    public function accederCommande(string $idCommande, string $email): CommandeDTO;
    public function validerCommande(string $idCommande, string $email): CommandeDTO;
}