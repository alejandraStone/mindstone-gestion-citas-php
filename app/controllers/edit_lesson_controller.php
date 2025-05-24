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

$required = ['id', 'pilates_type', 'coach', 'capacity', 'day', 'hour'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(['success' => false, 'message' => "Missing field: $field"]);
        exit;
    }
}

$conexion = getPDO();
$lessonModel = new Lesson($conexion);

$success = $lessonModel->updateLesson(
    $data['id'],
    $data['pilates_type'],
    $data['coach'],
    $data['capacity'],
    $data['day'],
    $data['hour']
);

echo json_encode($success);