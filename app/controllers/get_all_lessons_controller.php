<?php 
// Muestra todas las clases creadas al ADMIN en dashboard por AJAX

require_once __DIR__ . '/../config/config.php'; // Define ROOT_PATH y BASE_URL
require_once ROOT_PATH . '/app/config/database.php'; // Carga conexión PDO
require_once ROOT_PATH . '/app/models/add_a_class_model.php'; // Cargar el modelo de especialidades

header('Content-Type: application/json');

$conexion = getPDO();
$lessonModel = new Lesson($conexion);
$lessons = $lessonModel->getAllLessons();

echo json_encode(['success' => true, 'lessons' => $lessons]);
?>