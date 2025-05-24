<?php
require_once __DIR__ . '/../config/config.php'; // Define ROOT_PATH y BASE_URL
require_once ROOT_PATH . '/app/config/database.php'; // Carga conexión PDO
require_once ROOT_PATH . '/app/models/speciality_model.php'; // Cargar el modelo de especialidades

// Obtener las especialidades desde el modelo
$specialities = Speciality::getAll(); // Aquí obtenemos todas las especialidades

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] === "POST") {
     ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once ROOT_PATH . '/app/models/add_a_class_model.php'; // Modelo de clases
    header('Content-Type: application/json');

    // Sanitización básica
    $pilates_type = trim($_POST["pilates_type"] ?? '');
    $days = isset($_POST["days"]) ? json_decode($_POST["days"], true) : [];
    $capacity = intval($_POST["capacity"] ?? 0);
    $coach = intval($_POST["coach"] ?? 0);

    if (empty($pilates_type) || empty($days) || $capacity <= 0 || $coach <= 0) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    // Horarios
    $classEntries = [];
    foreach ($days as $dayName => $dayData) {
        if (isset($dayData['enabled']) && is_array($dayData['times'])) {
            foreach ($dayData['times'] as $hour) {
                $hour = trim($hour);
                if (!empty($hour)) {
                    $classEntries[] = ['day' => $dayName, 'hour' => $hour];
                }
            }
        }
    }

    if (empty($classEntries)) {
        echo json_encode(["success" => false, "message" => "You must select at least one valid schedule."]);
        exit;
    }

    // Guardar clases
    $conexion = getPDO();
    $lesson = new Lesson($conexion);
    $result = $lesson->addLessons($pilates_type, $coach, $capacity, $classEntries);

    echo json_encode($result);
    exit;

}

require ROOT_PATH . '/app/views/admin/add_a_class.php'; // Cargar vista
?>
