<?php
require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/bono_model.php';
require_once ROOT_PATH . '/app/session/session_manager.php';

header('Content-Type: application/json');

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Validar que el usuario esté autenticado
if (!isAuthenticated()) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit;
}

// Recoger y sanitizar input
$bonusId = isset($_POST['bonus_id']) ? (int)$_POST['bonus_id'] : 0;
$price = isset($_POST['price']) ? filter_var($_POST['price'], FILTER_VALIDATE_FLOAT) : false;

if ($bonusId <= 0 || $price === false || $price <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

try {
    $conexion = getPDO();
    $bonusModel = new Bonus($conexion);

    // Verificar que el bono existe y el precio es correcto
    $bonus = $bonusModel->getBonusById($bonusId);

    if (!$bonus) {
        echo json_encode(['success' => false, 'message' => 'Bonus not found.']);
        exit;
    }

    // Validar precio enviado contra precio real (evitar manipulación)
    if ((float)$bonus['price'] !== $price) {
        echo json_encode(['success' => false, 'message' => 'Price mismatch.']);
        exit;
    }

    // Calcular fecha de validez: 4 semanas desde hoy
    $validUntil = (new DateTime())->modify('+4 weeks')->format('Y-m-d H:i:s');

    // Registrar compra
    $userId = getUser()['id'];
    $result = $bonusModel->createPurchase($userId, $bonusId, $price, $validUntil);

    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'message' => 'Purchase successful!',
            'purchase_id' => $result['purchase_id'],
            'valid_until' => $validUntil
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => $result['message']]);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

exit;
?>
