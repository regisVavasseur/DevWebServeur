<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DbManager;

$dbcom = __DIR__ . '/../config/commande.db.ini';
$dbcat = __DIR__ . '/../config/catalog.db.ini';
$db = new DbManager();
$db->addConnection(parse_ini_file($dbcom), 'commande');
$db->addConnection(parse_ini_file($dbcat), 'catalog');
$db->setAsGlobal();
$db->bootEloquent();

$logger = new \Monolog\Logger('commandes');
$logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../logs/commandes.log', \Monolog\Level::Debug));

$commande_id = $argv[1];
$infoproduit = new \pizzashop\shop\domain\service\catalogue\ServiceCatalogue();
$service_commande = new \pizzashop\shop\domain\service\commande\ServiceCommande($infoproduit,$logger);
$res = $service_commande->validerCommande($commande_id);
print $res->toJson();

