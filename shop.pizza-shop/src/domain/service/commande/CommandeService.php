<?php

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\item\ItemDTO;
use Ramsey\Uuid\Uuid;
use Monolog\Logger;

class CommandeService implements iCommander
{

    private iInfoProduit $iInfoProduit;
    private Logger $logger;

    public function __construct(iInfoProduit $serviceinfoProduit)
    {
        $this->iInfoProduit = $serviceinfoProduit;
        $this->logger = new Logger('CommandeServiceLogger');

        //exemple d'utilisation du logger
        //$this->logger->info('CommandeServiceLogger: CommandeService instancié');
    }
    

    public function creerCommande(CommandeDTO $commandeDTO): CommandeDTO
    {
        $emailClient = $commandeDTO->getMailClient();
        $typeLivraison = $commandeDTO->getTypeLivraison();
        $arrayItems = $commandeDTO->getItemsDTO();

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

        return $commandeDTO;
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