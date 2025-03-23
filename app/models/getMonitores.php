<?php 
require_once dirname(__DIR__) . '/config/database.php';//llamo al archivo donde realizo la conexión a la DDBB con PDO
//me conecto a la ddbb

$query = "SELECT * FROM monitores WHERE disponible = 1"; //seleccionar todos los monitores disponibles
$result = $conexion->query($query);
$monitores = $result->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($monitores);//convierte un array en una cadena de texto JSON


?>