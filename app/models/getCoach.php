<?php 
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

header('Content-Type: application/json');

$conexion = getPDO(); // Asegúrate de tener esta función si no está

// Validar el parámetro speciality_id
$speciality_id = $_GET['speciality_id'] ?? null;

if (!$speciality_id) {
    echo json_encode(['success' => false, 'message' => 'No speciality ID provided.']);
    exit;
}

try {
    // Obtener coaches que tengan esa especialidad
    $query = "
        SELECT c.id, c.name 
        FROM coaches c
        INNER JOIN coach_speciality cs ON c.id = cs.coach_id
        WHERE cs.speciality_id = :speciality_id
    ";
    $stmt = $conexion->prepare($query);
    $stmt->execute(['speciality_id' => $speciality_id]);
    $coaches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'coaches' => $coaches]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
