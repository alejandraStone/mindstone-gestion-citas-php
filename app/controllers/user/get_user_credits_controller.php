<?php
require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '../app/session/session_manager.php';
require_once ROOT_PATH . '../app/config/database.php';
require_once ROOT_PATH . '../app/models/bono_model.php';


header('Content-Type: application/json');

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

try {
    $conexion = getPDO();
    $creditModel = new Bonus($conexion);

    $result = $creditModel->getUserCredits($user_id);

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
