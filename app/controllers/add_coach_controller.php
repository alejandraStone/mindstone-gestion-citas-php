<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/add_coach_model.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $name = $_POST['name'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $specialities = $_POST['speciality'] ?? [];

    // Validaciones básicas
    if (empty($name) || empty($lastName) || empty($email) || empty($phone)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Crear una instancia del modelo Coach
    $conexion = getPDO();
    $coach = new Coach($conexion);

    // Intentar agregar el coach
    $result = $coach->addCoach($name, $lastName, $email, $phone, $specialities);

    // El modelo SIEMPRE retorna un array tipo ['success'=>bool, 'message'=>string]
    echo json_encode($result);

} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}