<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;

// Charger les paramètres de configuration
$settings = require __DIR__ . '/settings.php';

// Créer un nouveau conteneur de dépendances
$containerBuilder = new ContainerBuilder();

// Ajouter les paramètres de configuration au conteneur
$containerBuilder->addDefinitions($settings);

// Ajouts des dépendances des actions
$actions = require __DIR__ . '/actions.php';
$containerBuilder->addDefinitions($actions);

// Compiler et créer le conteneur de dépendances
$container = $containerBuilder->build();

// Créer une instance de l'application en utilisant le conteneur pour l'injection de dépendances
AppFactory::setContainer($container);
$app = AppFactory::create();

// Ajouter les middlewares de l'application Slim
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Charger et appliquer les configurations des routes d'authentification
$authRoutes = require __DIR__ . '/gatewayRoutes.php';
$authRoutes($app);

// Retourner l'application configurée
return $app;