<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/bono_model.php';

header('Content-Type: application/json');

$conexion = getPDO();
$bonusModel = new Bonus($conexion);

// Solo aceptar peticiones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'create':
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $credits = intval($_POST['credits'] ?? 0);

            if (!$name || !$price || !$credits) {
                echo json_encode(['success' => false, 'message' => 'Missing fields.']);
                exit;
            }

            $result = $bonusModel->createBonus($name, $description, $price, $credits);
            echo json_encode($result);
            break;

        case 'update':
            $id = intval($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $credits = intval($_POST['credits'] ?? 0);

            if (!$id || !$name || !$price || !$credits) {
                echo json_encode(['success' => false, 'message' => 'Missing fields.']);
                exit;
            }

            $result = $bonusModel->updateBonus($id, $name, $description, $price, $credits);
            echo json_encode($result);
            break;

        case 'delete':
            $id = intval($_POST['id'] ?? 0);
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'Missing bonus ID.']);
                exit;
            }
            $result = $bonusModel->deleteBonus($id);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
?>
