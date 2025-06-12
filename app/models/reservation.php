<?php
require_once __DIR__ . '/../config/config.php';       // Esto define ROOT_PATH

class Reservation {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Crear una nueva reserva
    public function createReservation($lessonId, $userId) {
        // Verifica si la reserva ya existe para ese usuario y clase
        $query = "SELECT * FROM reservations WHERE lesson_id = :lesson_id AND user_id = :user_id";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute(['lesson_id' => $lessonId, 'user_id' => $userId]);

        // Si ya existe una reserva, no hacer nada
        if ($stmt->fetch()) {
            return false; // ya existe una reserva
        }

        // Si no existe, se inserta la nueva reserva
        $query = "INSERT INTO reservations (lesson_id, user_id) VALUES (:lesson_id, :user_id)";
        $stmt = $this->conexion->prepare($query);

        // Ejecutamos la consulta
        if ($stmt->execute(['lesson_id' => $lessonId, 'user_id' => $userId])) {
            return true; // la reserva fue realizada con éxito
        } else {
            return false; // error al guardar la reserva
        }
    }
}
?>
