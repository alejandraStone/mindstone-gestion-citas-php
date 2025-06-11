<?php
// Gestiona las reservas de clases de pilates por parte de un usuario mediante créditos/bonos

require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '/app/session/session_manager.php';
require_once ROOT_PATH . '/app/config/database.php'; // Conexión PDO
require_once ROOT_PATH . '/app/models/class_reservation_model.php'; // Modelo actualizado

// Siempre devolver JSON
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

$user_id = $user['id'];
$class_instance_id = $_POST['class_instance_id'] ?? null;

if (!$class_instance_id) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Class instance ID is required.',
        'dev_message' => 'Missing class_instance_id'
    ]);
    exit;
}

$conexion = getPDO();
$reservationModel = new ClassReservation($conexion);

// Intentar crear reserva (todo validado dentro del método)
$result = $reservationModel->createReservation($user_id, $class_instance_id);

if (!$result['success']) {
    // Código HTTP más adecuado según error
    $httpCode = 400;
    if (stripos($result['message'], 'fully booked') !== false) {
        $httpCode = 409;
    } elseif (stripos($result['message'], 'already reserved') !== false) {
        $httpCode = 409;
    } elseif (stripos($result['message'], 'past') !== false) {
        $httpCode = 400;
    }

    http_response_code($httpCode);
    echo json_encode([
        'success' => false,
        'message' => $result['message'],
        'dev_message' => $result['message']
    ]);
    exit;
}

// Reserva exitosa
http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Class reserved successfully! Check your reservations in the dashboard.',
    'dev_message' => "Reservation successful for user_id $user_id in class_instance_id $class_instance_id"
]);
exit;
?>
