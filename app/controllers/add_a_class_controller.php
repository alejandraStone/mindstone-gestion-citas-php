<?php
require_once __DIR__ . '/../config/config.php'; // Define ROOT_PATH y BASE_URL
require_once ROOT_PATH . '/app/config/database.php'; // Carga $conexion
require_once ROOT_PATH . '/app/models/add_a_class_model.php'; // Modelo add_a_class

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Sanitización básica de entrada
    $pilates_type = trim($_POST["pilates_type"] ?? '');
    $days = $_POST["days"] ?? [];
    $capacity = intval($_POST["capacity"] ?? 0);
    $coach = intval($_POST["coach"] ?? 0);

    if (empty($pilates_type) || empty($days) || $capacity <= 0 || $coach <= 0) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    // Preparar array de horarios válidos
    $classEntries = [];

    foreach ($days as $dayName => $dayData) {
        if (isset($dayData['enabled']) && isset($dayData['times']) && is_array($dayData['times'])) {
            foreach ($dayData['times'] as $hour) {
                $hour = trim($hour);
                if (!empty($hour)) {
                    $classEntries[] = [
                        'day' => $dayName,
                        'hour' => $hour
                    ];
                }
            }
        }
    }

    if (empty($classEntries)) {
        echo json_encode(["success" => false, "message" => "You must select at least one valid schedule."]);
        exit;
    }

    // Guardar clases usando el modelo
    $lesson = new Lesson($conexion);
    $result = $lesson->addLessons($pilates_type, $coach, $capacity, $classEntries);

    if ($result) {
        echo json_encode(["success" => true, "message" => "Classes saved successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "This class already exists for the selected day and time."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
