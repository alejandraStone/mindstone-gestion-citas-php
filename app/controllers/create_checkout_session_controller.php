<?php
/*
Archivo que maneja la creación de sesiones de pago con Stripe para bonos.
Este archivo recibe una solicitud POST con el ID del bono y crea una sesión de pago
*/

//Este archivo maneja la creación de sesiones de pago con Stripe para bonos
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/bono_model.php';
require_once ROOT_PATH . '/app/session/session_manager.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isAuthenticated() || $_SESSION['user']['role'] !== 'user') {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$bonusId = filter_input(INPUT_POST, 'bonus_id', FILTER_VALIDATE_INT);

if (!$bonusId) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid bonus ID']);
    exit;
}

require_once ROOT_PATH . '/app/controllers/bono_checkout_controller.php';
$bonus = getBonusData($bonusId);

if (!$bonus) {
    http_response_code(404);
    echo json_encode(['error' => 'Bonus not found']);
    exit;
}

Stripe::setApiKey(STRIPE_SECRET_KEY);

$YOUR_DOMAIN = 'http://localhost:80/mindStone/';

try {
    $checkout_session = Session::create([
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $bonus['name'],
                    'description' => $bonus['description'],
                ],
                'unit_amount' => intval($bonus['price'] * 100),
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'metadata' => [
            'user_id' => $_SESSION['user']['id'],
            'bonus_id' => $bonus['id']
        ],
        'success_url' => $YOUR_DOMAIN . 'app/controllers/user/payment_success_controller.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $YOUR_DOMAIN . 'app/views/user/payment_cancelled.php',
    ]);

    echo json_encode(['url' => $checkout_session->url]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Stripe error: ' . $e->getMessage()]);
    exit;
}
?>