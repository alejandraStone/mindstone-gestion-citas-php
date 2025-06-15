<?php
/*
Archivo que maneja la cancelación de reservas de clases de pilates.
*/
require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '/app/session/session_manager.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/class_reservation_model.php';


ini_set('display_errors', 0);
error_reporting(0);


header('Content-Type: application/json');
// Obtener usuario de sesión
$user = getUser();
if (!$user) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'You must be logged in.',
        'dev_message' => 'User not authenticated'
    ]);
    exit;
}
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['reservation_id']) || !is_numeric($input['reservation_id'])) {
    http_response_code(400);// Bad Request
    echo json_encode([
        'success' => false,
        'message' => 'Invalid reservation ID.'
    ]);
    exit;
}

$reservationId = (int)$input['reservation_id'];
$userId = $user['id'];

try {
    $pdo = getPDO();
    $reservationModel = new ClassReservation($pdo);

    $result = $reservationModel->cancelReservation($reservationId, $userId);

    if (!$result['success']) {
        http_response_code(400);
    }

    echo json_encode($result);

} catch (PDOException $e) {
    http_response_code(500);// Internal Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Unexpected error.',
        'dev_message' => $e->getMessage()
    ]);
}
