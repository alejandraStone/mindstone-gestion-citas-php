<?php

require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '/app/session/session_manager.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/bono_model.php';
require_once ROOT_PATH . '/vendor/autoload.php';


$user = getUser();

if (!$user) {
    header('Location: ' . BASE_URL . 'public/inicio.php');
    exit;
}

$userId = $user['id'];

$sessionId = $_GET['session_id'] ?? null;  // GET, porque Stripe redirige así

if (!$sessionId) {
    http_response_code(400);
    die('Missing session_id');
}

try {
    \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
    $stripeSession = \Stripe\Checkout\Session::retrieve($sessionId);
    $metadata = $stripeSession->metadata;
    $bonusId = $metadata->bonus_id ?? null;

    if (!$bonusId) {
        throw new Exception('Missing bonus_id in session metadata');
    }

    $conexion = getPDO();
    $bonusModel = new Bonus($conexion);

    // Evitar duplicados si ya se procesó esa sesión
    if ($bonusModel->purchaseExistsBySessionId($sessionId)) {
        throw new Exception('Purchase already processed');
    }

    $bonus = $bonusModel->getBonusById($bonusId);
    if (!$bonus) {
        throw new Exception('Bonus not found');
    }

    $price = $bonus['price'];
    $credits = $bonus['credits'];
    $validUntil = (new DateTime())->modify('+4 weeks')->format('Y-m-d');

    $purchase = $bonusModel->createPurchase($userId, $bonusId, $price, $validUntil, $sessionId, $credits);
    if (!$purchase['success']) {
        throw new Exception($purchase['message']);
    }

    $assign = $bonusModel->assignCredits($userId, $purchase['purchase_id'], $credits, $validUntil);
    if (!$assign['success']) {
        throw new Exception($assign['message']);
    }

    // Preparar datos para la vista
    $bonusName = $bonus['name'];

    include ROOT_PATH . '/app/views/user/payment_success.php';
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
