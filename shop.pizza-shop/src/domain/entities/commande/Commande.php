<?php

namespace pizzashop\shop\domain\entities\commande;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

class Commande extends \Illuminate\Database\Eloquent\Model
{

    const ETAT_CREE=1;
    const ETAT_VALIDE= 2;
    const ETAT_PAYE=3;
    const ETAT_LIVRE=4;
    const LIVRAISON_SUR_PLACE=1;
    const LIVRAISON_A_EMPORTER=2;
    const LIVRAISON_A_DOMICILE=3;


    protected $connection = 'commande';
    protected $table = 'commande';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [ 'delai, date_commande, type_livraison, etat, montant_total, id_client'];

    public function calculerMontantTotal(): float {
        $montantTotal = 0;
        foreach ($this->items as $item) {
            $montantTotal += ($item->tarif * $item->quantite);
        }
        $this->montant_total = $montantTotal;
        $this->save();
        return $montantTotal;
    }

    public function items() {
        return $this->hasMany(Item::class, 'commande_id');
    }

    public function toDTO() : CommandeDTO{
        $commandeDTO = new CommandeDTO(
            $this->type_livraison ,
            $this->mail_client,
            [],
        );
        $commandeDTO->setId($this->id);
        $commandeDTO->setDate($this->date_commande);
        $commandeDTO->setMontant($this->montant_total);
        $commandeDTO->setDelai($this->delai);
        $commandeDTO->setEtat($this->etat);
        foreach ($this->items as $item) {
            $commandeDTO->addItem($item->toDTO());
        }
        return $commandeDTO;
    }

}