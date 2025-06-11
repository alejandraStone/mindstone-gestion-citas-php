<?php
require_once __DIR__ . '/../config/config.php'; // Define ROOT_PATH y BASE_URL
require_once ROOT_PATH . '../app/config/database.php';
require_once ROOT_PATH . '../app/models/add_a_class_model.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'No class ID provided.'
        ]);
        exit;
    }

    $conexion = getPDO();
    $lessonModel = new Lesson($conexion);

    $result = $lessonModel->deleteLesson($data['id']);

    if (is_array($result)) {
        echo json_encode($result); // Devuelve success + message desde el modelo
    } else {
        echo json_encode([
            'success' => $result,
            'message' => $result
                ? 'The class was successfully deleted.'
                : 'Class not found or could not be deleted.'
        ]);
    }

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
