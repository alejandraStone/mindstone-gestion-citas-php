<?php

// Definir ROOT_PATH primero
define('ROOT_PATH', realpath(__DIR__ . '/../../'));

// Autoload Composer
require_once ROOT_PATH . '/vendor/autoload.php';

// Cargar variables de entorno desde .env
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Para URLs en HTML/CSS/JS
define('BASE_URL', '/mindStone/');

?>

