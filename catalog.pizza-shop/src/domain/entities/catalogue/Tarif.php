<?php

namespace pizzashop\catalog\domain\entities\catalogue;

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

    public function toDTO(): \pizzashop\catalog\domain\dto\catalogue\TarifDTO
    {
        return new \pizzashop\catalog\domain\dto\catalogue\TarifDTO(
            Produit::findOrfail($this->produit_id)->numero,
            Taille::findOrfail($this->taille_id)->toDTO(),
            $this->tarif
        );
    }

}