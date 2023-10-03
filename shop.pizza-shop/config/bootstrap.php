<?php

use pizzashop\shop\domain\utils\Eloquent;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

//gestionnaire d'erreur
$errorMiddleware = $app->addErrorMiddleware(true, false, false);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

// ajout du coneteneur de dépendances
$settings = require_once __DIR__ . DIRECTORY_SEPARATOR . 'settings.php';
$depedencies = require_once __DIR__ . DIRECTORY_SEPARATOR . 'dependencies.php';
$actions = require_once __DIR__ . DIRECTORY_SEPARATOR . 'actions.php';

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions($settings);
$builder->addDefinitions($depedencies);
$builder->addDefinitions($actions);
$container = $builder->build();
$app = AppFactory::createFromContainer($container);


// Initialisation de Eloquent
Eloquent::init(__DIR__ . DIRECTORY_SEPARATOR .'catalog.db.ini');
Eloquent::init(__DIR__ . DIRECTORY_SEPARATOR .'commande.db.ini');


// Eloquent::create()->addConnection(parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR .'catalog.db.ini'))->addConnection(parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR .'commande.db.ini'));



// Retourner l'application configurée
return $app;