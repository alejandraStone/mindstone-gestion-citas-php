<?php 
require_once dirname(__DIR__) . '/config/database.php';

class Lesson {
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    public function addLessons($pilates_type, $coach, $capacity, $classEntries){
        $query = "INSERT INTO pilates_lessons (pilates_type, coach, day, hour, capacity)
                  VALUES (:pilates_type, :coach, :day, :hour, :capacity)";
        $stmt = $this->conexion->prepare($query);

        foreach ($classEntries as $entry) {
            $stmt->execute([
                'pilates_type' => $pilates_type,
                'coach' => $coach,
                'day' => $entry['day'],
                'hour' => $entry['hour'],
                'capacity' => $capacity
            ]);
        }

        return true;
    }
}
