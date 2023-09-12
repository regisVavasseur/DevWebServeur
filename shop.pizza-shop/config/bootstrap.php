<?php

use pizzashop\shop\domain\utils\Eloquent;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

//gestionnaire d'erreur
$app->addErrorMiddleware(true, false, false);

// Initialisation de Eloquent
Eloquent::init(__DIR__ . DIRECTORY_SEPARATOR .'catalog.db.ini');
Eloquent::init(__DIR__ . DIRECTORY_SEPARATOR .'commande.db.ini');


// Retourner l'application configurée
return $app;