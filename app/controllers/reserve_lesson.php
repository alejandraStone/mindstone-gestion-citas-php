<?php
require_once '../config/database.php';
require_once '../models/reservation.php'; // Un modelo para reservas
require_once '../models/lesson.php'; // Para obtener la clase y su capacidad

// Establece el tipo de contenido como JSON desde el inicio
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['lesson_id'])) {
    $lessonId = $input['lesson_id'];
    
    session_start(); // para saber qué usuario está logueado
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Usuario no logueado']);
        exit;
    }

    $userId = $_SESSION['user_id'];

    // Verificamos la clase y la capacidad disponible
    $conexion = getPDO();
    $lesson = new Lesson($conexion);
    $class = $lesson->getLessonById($lessonId);

    if ($class && $class['capacity'] > 0) {
        // Reducir capacidad
        $newCapacity = $class['capacity'] - 1;
        
        $updateCapacity = $lesson->updateCapacity($lessonId, $newCapacity);

        if ($updateCapacity) {
            // Realizar la reserva
            $reservation = new Reservation($conexion);
            $success = $reservation->createReservation($lessonId, $userId);

            if ($success) {
                echo json_encode(['success' => true]);
                exit;
            } else {
                echo json_encode(['success' => false, 'error' => 'Error al guardar la reserva']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al actualizar la capacidad']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Clase llena o no disponible']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}
