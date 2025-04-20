<?php 
require_once dirname(__DIR__) . '/config/database.php';

// Traer ID, nombre de la bbdd de los coaches
$query = "SELECT id, name FROM coaches"; 
$result = $conexion->query($query);
$coaches = $result->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($coaches);
?>
