<?php
/*
Archivo que maneja la obtención de horarios ocupados para una clase de pilates específica.
Este archivo recibe parámetros GET para el tipo de pilates y el entrenador, y devuelve los horarios ocupados en formato JSON.
*/
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