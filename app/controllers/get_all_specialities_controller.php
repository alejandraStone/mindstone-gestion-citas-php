<?php
//Llama a todas las especialidades (tipos de clase) para mostrarlos por AJAX para modificar la clase

require_once __DIR__ . '/../config/config.php'; // Define ROOT_PATH y BASE_URL
require_once ROOT_PATH . '/app/models/speciality_model.php'; // Cargar el modelo de especialidades


header('Content-Type: application/json');

try {
    $specialities = Speciality::getAll();
    echo json_encode([
        'success' => true,
        'specialities' => $specialities,
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching specialities',
    ]);
}