<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\commande\ItemDTO;
use pizzashop\shop\domain\entities\catalogue\Categorie;
use pizzashop\shop\domain\entities\catalogue\Taille;
use pizzashop\shop\domain\entities\catalogue\Produit;
use Faker\Factory;
use pizzashop\shop\domain\entities\commande\Commande;

$dbcom = __DIR__ . '/../config/commande.db.ini';
$dbcat = __DIR__ . '/../config/catalog.db.ini';
$db = new DB();
$db->addConnection(parse_ini_file($dbcom), 'commande');
$db->addConnection(parse_ini_file($dbcat), 'catalog');
$db->setAsGlobal();
$db->bootEloquent();
$logger = new \Monolog\Logger('commandes');
$logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../logs/commandes.log', \Monolog\Level::Debug));

$commandeDTO = new CommandeDTO("lucien@gmal.com",  Commande::LIVRAISON_A_EMPORTER);
$commandeDTO->addItem(new ItemDTO(1, 4, 1));
$commandeDTO->addItem(new ItemDTO(2, 3, 2));
$commandeDTO->addItem(new ItemDTO(5, 3, 2));

$infoproduit = new \pizzashop\shop\domain\service\catalogue\ServiceCatalogue();
$service_commande = new \pizzashop\shop\domain\service\commande\ServiceCommande($infoproduit,$logger);
$res = $service_commande->creerCommande($commandeDTO);
print $res->toJson();

