<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/class_reservation_model.php';

header('Content-Type: application/json');

try {
    $conexion = getPDO();
    $reservationModel = new ClassReservation($conexion);

    // Este método devuelve crecimiento mensual listo
    $growthData = $reservationModel->getMonthlyReservationGrowth($conexion);

    if (!$growthData['success']) {
        throw new Exception('Error calculating growth: ' . ($growthData['message'] ?? ''));
    }

    // Para mostrar el total de reservas hechas, llama a countReservationsInMonth con el mes actual
    $now = new DateTime();
    $currentYear = (int)$now->format('Y');
    $currentMonth = (int)$now->format('m');
    $countResult = $reservationModel->countReservationsInMonth($currentYear, $currentMonth);

    if (!$countResult['success']) {
        throw new Exception('Error fetching current month reservations: ' . $countResult['message']);
    }

    echo json_encode([
        'success' => true,
        'total_reservations_this_month' => $countResult['count'],
        'growth_percentage' => $growthData['growth_percentage'],
        'message' => $growthData['message']
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Unexpected server error.',
        'error' => $e->getMessage()
    ]);
}
