<?php

function getConfig()
{
    // Charger les variables d'environnement depuis .env
    $envFile = __DIR__ . '/../.env';
    
    if (!file_exists($envFile)) {
        throw new Exception("Le fichier .env est manquant. Copiez .env.example vers .env et configurez-le.");
    }

    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $config = [];

    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parser les lignes KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $config[trim($key)] = trim($value);
        }
    }

    // Valider les paramètres requis
    $required = ['SMTP_HOST', 'SMTP_PORT', 'SMTP_FROM_EMAIL', 'SMTP_FROM_NAME', 'SMTP_TO_EMAIL'];
    foreach ($required as $param) {
        if (!isset($config[$param]) || empty($config[$param])) {
            throw new Exception("Paramètre manquant dans .env: {$param}");
        }
    }

    return $config;
}
