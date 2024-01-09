<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;

$dbconf = __DIR__ . '/../config/catalog.db.ini';
$db = new DB();
$db->addConnection(parse_ini_file($dbconf), 'catalogue');
$db->setAsGlobal();
$db->bootEloquent();

$ps = new \pizzashop\shop\domain\service\catalogue\ServiceCatalogue();
try {
    $produit = $ps->getProduit(1, 4);
    echo $produit->toJson();
} catch (\pizzashop\shop\domain\service\catalogue\exception\ServiceCatalogueNotFoundException $e) {
    echo $e->getMessage();
}
