<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/add_a_class_model.php';

header('Content-Type: application/json');

$pilates_type = $_GET['pilates_type'] ?? '';
$coach = $_GET['coach'] ?? '';

if (!$pilates_type || !$coach) {
    echo json_encode(['success' => false, 'occupied' => []]);
    exit;
}

$conexion = getPDO();
$lesson = new Lesson($conexion);
$occupied = $lesson->getOccupiedSchedules($pilates_type, $coach);

echo json_encode(['success' => true, 'occupied' => $occupied]);
exit;