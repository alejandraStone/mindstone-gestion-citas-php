<?php 
require_once "../models/add_a_class_model.php";
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $pilates_type = $_POST["pilates_type"] ?? null;
    $days = $_POST["days"] ?? [];
    $capacity = $_POST["capacity"] ?? null;
    $coach = $_POST["coach"] ?? null;

    if (empty($pilates_type) || empty($days) || empty($capacity) || empty($coach)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Recolectar las clases activadas con sus respectivos horarios
    $classEntries = [];

    foreach ($days as $dayName => $dayData) {
        if (isset($dayData['enabled']) && isset($dayData['times'])) {
            foreach ($dayData['times'] as $hour) {
                $classEntries[] = [
                    'day' => $dayName,
                    'hour' => $hour
                ];
            }
        }
    }

    if (empty($classEntries)) {
        echo "Debes seleccionar al menos un horario para los días marcados.";
        exit;
    }

    // Guardar clases
    $lesson = new Lesson($conexion);
    $lesson->addLessons($pilates_type, $coach, $capacity, $classEntries);

    echo "Clases guardadas correctamente.";
}
?>
