<?php

use pizzashop\shop\domain\entities\catalogue\Produit;

class Commande extends \Illuminate\Database\Eloquent\Model
{

    protected $connection = 'commande';
    protected $table = 'commande';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'delai, date_commande, type_livraison, etat, montant_total, id_client'];

}