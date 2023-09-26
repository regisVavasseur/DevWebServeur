<?php

use pizzashop\shop\domain\utils\Eloquent;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

//gestionnaire d'erreur
$errorMiddleware = $app->addErrorMiddleware(true, false, false);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

// Initialisation de Eloquent
Eloquent::init(__DIR__ . DIRECTORY_SEPARATOR .'catalog.db.ini');
Eloquent::init(__DIR__ . DIRECTORY_SEPARATOR .'commande.db.ini');


// Retourner l'application configurée
return $app;