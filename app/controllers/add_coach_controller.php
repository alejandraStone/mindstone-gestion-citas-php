<?php
require_once __DIR__ . '/../config/config.php'; // Define ROOT_PATH y BASE_URL
require_once ROOT_PATH . '/app/config/database.php'; // Carga $conexion
require_once ROOT_PATH . '/app/models/add_coach_model.php'; // Modelo add_a_class

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $finish_time = $_POST['finish_time'] ?? '';
    $specialities = $_POST['speciality'] ?? [];

    // Validaciones básicas
    if (empty($name) || empty($email) || empty($phone)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Crear una instancia del modelo Coach
    $conexion = getPDO();
    $coach = new Coach($conexion);

    // Intentar agregar el coach
    $result = $coach->addCoach($name, $email, $phone, $start_time, $finish_time, $specialities);

    if ($result === true) {
        echo json_encode(['success' => true, 'message' => 'Coach added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => $result]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
