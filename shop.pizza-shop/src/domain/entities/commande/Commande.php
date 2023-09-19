<?php

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\entities\catalogue\Produit;

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
    public $timestamps = false;
    protected $fillable = [ 'delai, date_commande, type_livraison, etat, montant_total, id_client'];

    public function calculerMontantTotal(){}

    public function toDTO() : CommandeDTO{
        $commandeDTO = new CommandeDTO($this->id_client);
    }

}