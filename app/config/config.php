<?php
/*
Archivo de configuración principal de la aplicación.
Este archivo define constantes globales y carga las dependencias necesarias.
*/


// Definir ROOT_PATH primero
define('ROOT_PATH', realpath(__DIR__ . '/../../'));

// Autoload Composer
require_once ROOT_PATH . '/vendor/autoload.php';

// Cargar variables de entorno desde .env
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

//Defino la variable de clave secreta de Stripe para usarla en el checkout
define('STRIPE_SECRET_KEY', $_ENV['STRIPE_SECRET_KEY']);

// Definir la URL base de la aplicación
// Esta URL se usa para redirigir a los usuarios y construir enlaces absolutos. Para URLs en HTML/CSS/JS
define('BASE_URL', $_ENV['BASE_URL']);
?>

