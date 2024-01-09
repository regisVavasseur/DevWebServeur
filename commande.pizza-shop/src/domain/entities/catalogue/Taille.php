<?php

namespace pizzashop\shop\domain\entities\catalogue;

class Taille extends \Illuminate\Database\Eloquent\Model
{

    protected $connection = 'catalog';
    protected $table = 'taille';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'libelle'];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'tarif', 'taille_id', 'produit_id');
    }

    public function toDTO(): \pizzashop\shop\domain\dto\catalogue\TailleDTO
    {
        return new \pizzashop\shop\domain\dto\catalogue\TailleDTO(
            $this->id,
            $this->libelle
        );
    }

}