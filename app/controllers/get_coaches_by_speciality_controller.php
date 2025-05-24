<?php 
// Muestra los datos de los coaches (todos o por especialidad) por AJAX
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/add_coach_model.php'; // Cargar el modelo de coaches

header('Content-Type: application/json');

$speciality_id = $_GET['speciality_id'] ?? null;

try {
    $conexion = getPDO();
    $coachModel = new Coach($conexion);

    if ($speciality_id) {
        $coaches = $coachModel->getBySpeciality($speciality_id);
    } else {
        $coaches = $coachModel->getAll();
    }
    echo json_encode(['success' => true, 'coaches' => $coaches]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>