<?php
require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/bono_model.php';
require_once ROOT_PATH . '/app/session/session_manager.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!isAuthenticated()) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit;
}

$bonusId = isset($_POST['bonus_id']) ? (int)$_POST['bonus_id'] : 0;
$price = isset($_POST['price']) ? filter_var($_POST['price'], FILTER_VALIDATE_FLOAT) : false;
$stripeSessionId = isset($_POST['stripe_session_id']) ? trim($_POST['stripe_session_id']) : '';

if ($bonusId <= 0 || $price === false || $price <= 0 || empty($stripeSessionId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

try {
    $conexion = getPDO();
    $bonusModel = new Bonus($conexion);

    $bonus = $bonusModel->getBonusById($bonusId);

    if (!$bonus) {
        echo json_encode(['success' => false, 'message' => 'Bonus not found.']);
        exit;
    }

    if ((float)$bonus['price'] !== $price) {
        echo json_encode(['success' => false, 'message' => 'Price mismatch.']);
        exit;
    }

    if ($bonusModel->purchaseExistsBySessionId($stripeSessionId)) {
        echo json_encode(['success' => false, 'message' => 'Duplicate purchase detected.']);
        exit;
    }

    $validUntil = (new DateTime())->modify('+4 weeks')->format('Y-m-d H:i:s');
    $userId = getUser()['id'];
    $credits = (int)$bonus['credits'];

    $result = $bonusModel->createPurchase($userId, $bonusId, $price, $validUntil, $stripeSessionId, $credits);

    if ($result['success']) {
        $assign = $bonusModel->assignCredits($userId, $result['purchase_id'], $credits, $validUntil);

        if ($assign['success']) {
            echo json_encode([
                'success' => true,
                'message' => 'Purchase and credits assigned successfully.',
                'purchase_id' => $result['purchase_id'],
                'valid_until' => $validUntil
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => $assign['message']]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => $result['message']]);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
exit;
