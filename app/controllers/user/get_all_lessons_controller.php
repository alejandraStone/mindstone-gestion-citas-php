<?php 
// Muestra todas las clases programadas reales (fechadas) al usuario vía AJAX
require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '../app/config/database.php';
require_once ROOT_PATH . '../app/models/add_a_class_model.php';

header('Content-Type: application/json');

try {
    $conexion = getPDO();
    $lessonModel = new Lesson($conexion);
    $lessons = $lessonModel->getAllInstancesForUser();

    echo json_encode($lessons);
} catch (Exception $e) {
     http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Internal Server Error',
        'dev_message' => $e->getMessage()
    ]);
    exit;
}
