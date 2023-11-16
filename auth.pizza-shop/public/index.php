<?php
declare(strict_types=1);

header('Access-Control-Allow-Origin: *');

// Autorise les méthodes HTTP spécifiées
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');

// Autorise les en-têtes personnalisés et les en-têtes standard
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Autorise l'envoi de cookies sur les requêtes CORS
header('Access-Control-Allow-Credentials: true');

// Autres en-têtes utiles
header('Content-Type: application/json');
header('Access-Control-Max-Age: 3600');

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../config/bootstrap.php';
$app->run();