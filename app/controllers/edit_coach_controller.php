<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/add_coach_model.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $name = trim($_POST['name'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $specialities = $_POST['speciality'] ?? []; 

    // Validaciones
    if (!$id || empty($name) || empty($lastName) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($phone)) {
        echo json_encode(['success' => false, 'message' => 'Please complete all fields correctly.']);
        exit;
    }

    if (!is_array($specialities)) {
        echo json_encode(['success' => false, 'message' => 'Specialities must be an array.']);
        exit;
    }

    $specialities = array_map('intval', $specialities); // Sanitizar

    try {
        $pdo = getPDO();
        $coach = new Coach($pdo);

        $result = $coach->update($id, $name,$lastName,  $email, $phone, $specialities);

        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
