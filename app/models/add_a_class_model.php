<?php 
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php'; 

class Lesson {
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

public function addLessons($pilates_type, $coach, $capacity, $classEntries) {
    try {
        $this->conexion->beginTransaction();

        // Se verifica si existe ya una clase ese mismo día, a la misma hora...
        $query = "SELECT COUNT(*) FROM pilates_lessons WHERE pilates_type = :pilates_type
                  AND coach = :coach AND day = :day AND hour = :hour AND capacity = :capacity";
        $stmt = $this->conexion->prepare($query);

        foreach ($classEntries as $entry) {
            $stmt->execute([
                'pilates_type' => $pilates_type,
                'coach' => $coach,
                'day' => $entry['day'],
                'hour' => $entry['hour'],
                'capacity' => $capacity
            ]);
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                $this->conexion->rollBack();
                return [
                        'success' => false,
                        'message' => 'There is already a class with that type, coach, day and time.'
                    ]; // Hay duplicado, aborta todo
            }
        }

        // Si ninguna existe, inserta todo
        $queryInsert = "INSERT INTO pilates_lessons (pilates_type, coach, day, hour, capacity)
                        VALUES (:pilates_type, :coach, :day, :hour, :capacity)";
        $stmtInsert = $this->conexion->prepare($queryInsert);
        foreach ($classEntries as $entry) {
            $success = $stmtInsert->execute([
                'pilates_type' => $pilates_type,
                'coach' => $coach,
                'day' => $entry['day'],
                'hour' => $entry['hour'],
                'capacity' => $capacity
            ]);
            if (!$success) {
                $this->conexion->rollBack();
                 return [
                        'success' => false,
                        'message' => 'Unexpected error when adding the class.'
                    ];
            }
        }

        $this->conexion->commit();
        return [
                'success' => true,
                'message' => 'Classes added correctly.'
            ];

    } catch (PDOException $e) {
        if ($this->conexion->inTransaction()) {
            $this->conexion->rollBack();
        }
        // Si el error es por duplicado (por el índice UNIQUE agregado en la bbdd)
            if ($e->getCode() === '23000') {
                return [
                    'success' => false,
                    'message' => 'There is already a class with that type, coach, day and time.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Unexpected error when adding the class.'
                ];
        }
    }
}
}
