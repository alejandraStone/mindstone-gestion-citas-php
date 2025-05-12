<?php 
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php'; 

class Lesson {
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

   public function addLessons($pilates_type, $coach, $capacity, $classEntries) {
    $query = "SELECT COUNT(*) FROM pilates_lessons WHERE pilates_type = :pilates_type
              AND coach = :coach AND day = :day AND hour = :hour AND capacity = :capacity";
    $stmt = $this->conexion->prepare($query);

    try {
        $this->conexion->beginTransaction();

        foreach ($classEntries as $entry) {
            // Verificar si la clase ya existe
            $stmt->execute([
                'pilates_type' => $pilates_type,
                'coach' => $coach,
                'day' => $entry['day'],
                'hour' => $entry['hour'],
                'capacity' => $capacity
            ]);
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                error_log("Class already exist: " . json_encode($entry));
                // Si la clase ya existe, no se inserta
                $this->conexion->rollBack();
                return false; // Clase duplicada
            }

            // Insertar la clase si no existe
            $queryInsert = "INSERT INTO pilates_lessons (pilates_type, coach, day, hour, capacity)
                            VALUES (:pilates_type, :coach, :day, :hour, :capacity)";
            $stmtInsert = $this->conexion->prepare($queryInsert);
            $success = $stmtInsert->execute([
                'pilates_type' => $pilates_type,
                'coach' => $coach,
                'day' => $entry['day'],
                'hour' => $entry['hour'],
                'capacity' => $capacity
            ]);

            if (!$success) {
                $this->conexion->rollBack();
                return false;
            }
        }

        $this->conexion->commit();
        return true;

    } catch (PDOException $e) {
        $this->conexion->rollBack();
        error_log("Error adding lessons: " . $e->getMessage());
        return false;
    }
}
}
