<?php
require_once __DIR__ . '/config.php'; // Carga BASE_URL y ROOT_PATH

function getPDO()
{
    //Aquí configuro la conexíon con la DDBB con PDO
    $dsn = "mysql:host=localhost;dbname=mindstone;charset=utf8";
    $username = "root";
    $password = "";
    $error = "";

    try {
        //conexión
        $conexion = new PDO($dsn, $username, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //manejo de errores
        return $conexion; 
    } catch (PDOException $error) {
        die("Fallo en la conexión: " . $error->getMessage()); // Muestro el mensaje de error y detengo la ejecución
    }
}
?>