<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/add_a_class_model.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing class ID']);
    exit;
}

$conexion = getPDO();
$lessonModel = new Lesson($conexion);

try {
    $success = $lessonModel->deleteLesson($data['id']);
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Class deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Class not found or already deleted']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}