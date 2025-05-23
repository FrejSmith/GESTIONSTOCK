<?php
// filepath: /Users/macbookpro/GestionStock/public/index.php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';

// Charger les variables d'environnement si elles ne sont pas définies
if (!isset($_SERVER['APP_ENV'])) {
    (new Dotenv())->loadEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG'] ?? false) {
    umask(0000);
    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(
        explode(',', $trustedProxies),
        Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST
    );
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Kernel($_SERVER['APP_ENV'] ?? 'dev', (bool) ($_SERVER['APP_DEBUG'] ?? false));
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
