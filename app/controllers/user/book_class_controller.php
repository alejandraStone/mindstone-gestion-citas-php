<?php
//Gestiona las reservas de clases de pilates por parte de un usuario mediante el uso de créditos/bonos

require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '/app/session/session_manager.php';
require_once ROOT_PATH . '../app/config/database.php'; // Conexión PDO
require_once ROOT_PATH . '/app/models/reservation_model.php';


// Devolver siempre JSON
header('Content-Type: application/json');

// Obtener datos de sesión y petición
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
$lesson_id = $_POST['lesson_id'] ?? null;

if (!$lesson_id) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Lesson ID is required.',
        'dev_message' => 'Missing lesson_id'
    ]);
    exit;
}

$conexion = getPDO();
$model = new ReservationModel($conexion);
$error = null;

// Verificar capacidad
if (!$model->hasAvailableCapacity($lesson_id, $error)) {
    http_response_code(409); // Conflict
    echo json_encode([
        'success' => false,
        'message' => 'This class is already full.',
        'dev_message' => $error ?: 'No available capacity in lesson_id ' . $lesson_id
    ]);
    exit;
}

// Verificar créditos del usuario
$available_credits = $model->getAvailableCredits($user_id, $error);

if ($available_credits < 1) {
    http_response_code(402); // Payment Required
    echo json_encode([
        'success' => false,
        'message' => 'You don’t have any credits left. Please purchase a new pack.',
        'dev_message' => $error ?: "User $user_id has $available_credits credits"
    ]);
    exit;
}

// Intentar reservar la clase
$success = $model->reserveLessonWithCredit($user_id, $lesson_id, $error);

if (!$success) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Oops! Something went wrong while booking your class.',
        'dev_message' => $error ?: 'Reservation failed on backend'
    ]);
    exit;
}

// Reserva exitosa
http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Class reserved successfully! 1 credit has been used.',
    'dev_message' => "Reservation successful for user_id $user_id in lesson_id $lesson_id"
]);
exit;
?>
