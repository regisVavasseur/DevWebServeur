<?php

use pizzashop\commande\domain\middlewares\Cors;
use pizzashop\commande\domain\utils\Eloquent;
use Slim\Factory\AppFactory;

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
$app->add(new Cors());
$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

//gestionnaire d'erreur
$errorMiddleware = $app->addErrorMiddleware(true, false, false);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

// Initialisation de Eloquent

$init = new Eloquent();
$init->init(__DIR__ . DIRECTORY_SEPARATOR .'catalog.db.ini', $app->getContainer()->get('connection.name.catalogue'));
$init->init(__DIR__ . DIRECTORY_SEPARATOR .'commande.db.ini', $app->getContainer()->get('connection.name.commande'));

// Eloquent::create()->addConnection(parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR .'catalog.db.ini'))->addConnection(parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR .'commande.db.ini'));



// Retourner l'application configurée
return $app;