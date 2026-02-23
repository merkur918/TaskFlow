<?php

require_once __DIR__ . '/../app/core/autoload.php';
require_once __DIR__ . '/../app/core/SessionManager.php';

$session = new SessionManager(900);

// URLs limpias

$ruta = $_GET['url']
    ?? trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($ruta === '') {
    $ruta = 'login';
}

// Definición de rutas

$map = [

    'login' => [
        'controller' => 'AuthController',
        'action'     => 'index',
        'nivel'      => 0
    ],

    'login_post' => [
        'controller' => 'AuthController',
        'action'     => 'authenticate',
        'nivel'      => 0
    ],

    'logout' => [
        'controller' => 'AuthController',
        'action'     => 'logout',
        'nivel'      => 1
    ],

];

// Ruta no encontrada

if (!isset($map[$ruta])) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Error 404 - Ruta '$ruta' no encontrada</h1>";
    exit;
}

// Obtener datos de la ruta

$controlador   = $map[$ruta]['controller'];
$actionName    = $map[$ruta]['action'];
$requiredLevel = $map[$ruta]['nivel'];

// Verificación de acceso

if ($requiredLevel > 0 && !$session->isLoggedIn()) {
    header("Location: /login");
    exit;
}

// Ejecutar controlador

require_once __DIR__ . "/../app/controllers/$controlador.php";

$controller = new $controlador($session);

if (!method_exists($controller, $actionName)) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Acción '$actionName' no encontrada</h1>";
    exit;
}

$controller->$actionName();