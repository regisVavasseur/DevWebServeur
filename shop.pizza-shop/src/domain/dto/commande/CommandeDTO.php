<?php

namespace pizzashop\shop\domain\dto\commande;

use PhpParser\Node\Expr\Cast\Double;
use pizzashop\shop\domain\dto\DTO;
use function DI\add;

class CommandeDTO extends DTO
{

    private string $id;
    private string $date;
    private int $type_livraison;
    private string $mail_client;
    private float $montant;
    private int $delai;
    private array $itemsDTO;
    private int $etat;


    public function __construct(string $id, string $date, int $type_livraison, string $mail_client, float $montant, int $delai, array $itemsDTO, int $etat = 1)
    {
        $this->id = $id;
        $this->date = $date;
        $this->type_livraison = $type_livraison;
        $this->mail_client = $mail_client;
        $this->montant = $montant;
        $this->delai = $delai;
        $this->itemsDTO = $itemsDTO;
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

    public function getPrixTotal(): float
    {
        return $this->prix_total;
    }

    public function setPrixTotal(float $prix_total): void
    {
        $this->prix_total = $prix_total;
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

    //create function toString
    public function __toString(): string
    {
        $items = [];
        foreach ($this->itemsDTO as $item) {
            $items[] = $item->__toString();
        }
        return json_encode([
            'id' => $this->id,
            'date' => $this->date,
            'type_livraison' => $this->type_livraison,
            'mail_client' => $this->mail_client,
            'montant' => $this->montant,
            'delai' => $this->delai,
            'items' => $items,
            'etat' => $this->etat
        ]);
    }


}