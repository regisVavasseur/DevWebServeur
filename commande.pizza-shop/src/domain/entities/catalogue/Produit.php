<?php

namespace pizzashop\commande\domain\entities\catalogue;

use pizzashop\commande\domain\dto\catalogue\ProduitDTO;

class Produit extends \Illuminate\database\eloquent\Model
{

    const TAILLE_NORMALE = '1';
    const TAILLE_GRANDE = '2';

    protected $connection = 'catalog';
    protected $table = 'produit';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['numero', 'libelle', 'description','image'];

    public function categorie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function tailles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Taille::class, 'tarif', 'produit_id', 'taille_id')
            ->withPivot('tarif');
    }

    public function tarif(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tarif::class, 'produit_id');
    }

    public function toDTO(): ProduitDTO
    {
        return new ProduitDTO(
            $this->numero,
            $this->libelle,
            $this->description,
            $this->image,
            $this->categorie()->firstOrFail()->toDTO(),
            $this->tarif()->get()->map(function ($tarif) {
                return $tarif->toDTO();
            })->toArray()
        );
    }

}