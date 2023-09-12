<?php

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

}