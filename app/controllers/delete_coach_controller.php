<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/add_coach_model.php';


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coachId = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($coachId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid coach ID.']);
        exit;
    }

    try {
        $pdo = getPDO();
        $coachModel = new Coach($pdo);
        $result = $coachModel->delete($coachId);

        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
