<?php

namespace pizzashop\shop\domain\entities\commande;

use pizzashop\shop\domain\dto\item\ItemDTO;

class Item extends \Illuminate\Database\Eloquent\Model
{

    protected $connection = 'commande';
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'numero, libelle, taille, tarif, quantite', 'libelle_taille'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    public function toDTO() : ItemDTO {
        $itemDTO = new ItemDTO($this->numero, $this->taille, $this->quantite);
        $itemDTO->setPrix($this->tarif);
        $itemDTO->setLibelle($this->libelle);
        $itemDTO->setLibelleTaille($this->libelle_taille);
        return $itemDTO;
    }

}