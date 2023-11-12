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

// Setting up Eloquent
$capsule = new Capsule;
$capsule->addConnection($settings['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Ajouter les dépendances et les actions au conteneur
$dependencies = require __DIR__ . '/dependencies.php';
$actions = require __DIR__ . '/actions.php';
$containerBuilder->addDefinitions($dependencies);
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

// Boot Eloquent
$capsule = new Capsule;
$capsule->addConnection($container->get('settings')['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Charger et appliquer les configurations des routes d'authentification
$authRoutes = require __DIR__ . '/authRoutes.php';
$authRoutes($app);

// Retourner l'application configurée
return $app;