<?php
/*
Archivo que maneja la obtención de reservas de clases de pilates del usuario autenticado.
*/
require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '/app/session/session_manager.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/class_reservation_model.php';

header('Content-Type: application/json');

// Validar sesión
$user = getUser();
if (!$user) {
    http_response_code(401);// Unauthorized
    echo json_encode([
        'success' => false,
        'message' => 'You must be logged in.',
        'dev_message' => 'User not authenticated'
    ]);
    exit;
}

$user_id = $user['id'];

// Obtener parámetros de paginación desde GET
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : null;
$offset = isset($_GET['offset']) && is_numeric($_GET['offset']) ? (int)$_GET['offset'] : null;

try {
    $conexion = getPDO();
    $reservationModel = new ClassReservation($conexion);

    $result = $reservationModel->getUserReservations($user_id, $limit, $offset);

    if (!$result['success']) {
        http_response_code(500);
    }

    echo json_encode($result);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Unexpected error.',
        'dev_message' => $e->getMessage()
    ]);
}
