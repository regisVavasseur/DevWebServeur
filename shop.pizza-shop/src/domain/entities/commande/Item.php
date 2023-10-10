<?php

namespace pizzashop\shop\domain\entities\commande;

use pizzashop\shop\domain\dto\item\ItemDTO;

class Item extends \Illuminate\Database\Eloquent\Model
{

    protected $connection = 'commande';
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'numero, libelle, taille, tarif, quantite'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    public function toDTO() : ItemDTO {
        return new ItemDTO($this->id ,$this->numero, $this->libelle, $this->taille, $this->quantite,$this->tarif);
    }

}