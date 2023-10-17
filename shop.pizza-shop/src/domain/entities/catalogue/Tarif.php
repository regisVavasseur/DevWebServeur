<?php

namespace pizzashop\shop\domain\entities\catalogue;

use pizzashop\shop\domain\entities\commande\Commande;

class Tarif extends \Illuminate\database\eloquent\Model
{

    protected $connection = 'catalog';
    protected $table = 'tarif';
    protected $primaryKey = 'id';
    public $timestamps = false;



    public function produit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function taille(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Taille::class, 'taille_id');
    }

}