<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/add_coach_model.php'; // Cargar el modelo de especialidades
require_once ROOT_PATH . '/app/models/speciality_model.php';  // modelo Speciality


header('Content-Type: application/json');

// Recibir el id del coach por POST
$coach_id = $_POST['coach_id'] ?? null;

if (!$coach_id || !is_numeric($coach_id)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid or missing coach ID.'
    ]);
    exit;
}

try {
    $pdo = getPDO();
    $coachModel = new Coach($pdo);

    $coach = $coachModel->getById($coach_id);
    if (!$coach) {
        echo json_encode([
            'success' => false,
            'message' => 'Coach not found.'
        ]);
        exit;
    }

    // Todas las especialidades disponibles
    $allSpecialities = Speciality::getAll();

    // IDs de las especialidades asignadas al coach
    $coachSpecialitiesIds = $coachModel->getSpecialityIdsByCoach($coach_id);

    echo json_encode([
        'success' => true,
        'coach' => $coach,
        'allSpecialities' => $allSpecialities,
        'coachSpecialitiesIds' => $coachSpecialitiesIds
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}