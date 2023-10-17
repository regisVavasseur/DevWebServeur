<?php

namespace pizzashop\shop\domain\dto\commande;

use pizzashop\shop\domain\dto\DTO;
use pizzashop\shop\domain\dto\item\ItemDTO;
use pizzashop\shop\domain\entities\commande\Commande;

class CommandeDTO extends DTO
{

    private string $id;
    private int $delai;
    private string $date;
    private int $type_livraison;
    private int $etat;
    private float $montant;
    private string $mail_client;

    private array $itemsDTO;

    public function __construct(int $type_livraison, string $mail_client, array $itemsDTO, int $etat=Commande::ETAT_CREE)
    {
        $this->type_livraison = $type_livraison;
        $this->mail_client = $mail_client;
        $this->itemsDTO = $itemsDTO;
        $this->delai = 0;
        $this->etat = $etat;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getTypeLivraison(): int
    {
        return $this->type_livraison;
    }

    public function setTypeLivraison(int $type_livraison): void
    {
        $this->type_livraison = $type_livraison;
    }

    public function getMailClient(): string
    {
        return $this->mail_client;
    }

    public function setMailClient(string $mail_client): void
    {
        $this->mail_client = $mail_client;
    }

    public function getDelai(): int
    {
        return $this->delai;
    }

    public function setDelai(int $delai): void
    {
        $this->delai = $delai;
    }

    public function getItemsDTO(): array
    {
        return $this->itemsDTO;
    }

    public function setItemsDTO(array $itemsDTO): void
    {
        $this->itemsDTO = $itemsDTO;
    }

    public function getMontant() : float {
        return $this->montant;
    }

    public function addItem(ItemDTO $item) : void {
        $this->itemsDTO[] = $item;
    }

    public function setMontant(float|int $total_price)
    {
        $this->montant = $total_price;
    }

    public function getEtat(): int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): void
    {
        $this->etat = $etat;
    }

    public function calculerMontant() : void {
        $total_price = 0;
        foreach ($this->itemsDTO as $item) {
            $total_price += $item->getPrix();
        }
        $this->montant = $total_price;
    }

    public function toArray(): array
    {
        $items = [];
        foreach ($this->itemsDTO as $item) {
            $items[] = $item->toArray();
        }

        return [
            'id' => $this->id,
            'date' => $this->date,
            'type_livraison' => $this->type_livraison,
            'mail_client' => $this->mail_client,
            'montant' => $this->montant,
            'delai' => $this->delai,
            'items' => $items,
            'etat' => $this->etat
        ];
    }


}