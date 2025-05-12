<?php 
require_once __DIR__ . '/../config/config.php';       // Esto define ROOT_PATH
require_once ROOT_PATH . '/app/config/database.php';  // Esto la conexión
class Lesson {
    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    public function getAllLessons (){
        $query = "SELECT * FROM pilates_lessons";
        $result = $this->conexion->query($query);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLessonsByDay($day){
    $query = "SELECT l.id, l.pilates_type, l.hour, c.name as coach_name 
              FROM pilates_lessons l 
              JOIN coaches c ON l.coach = c.id 
              WHERE l.day = :day";
    $stmt = $this->conexion->prepare($query);
    $stmt->execute(['day' => $day]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Obtener clase por ID
    public function getLessonById($lessonId) {
        $query = "SELECT * FROM pilates_lessons WHERE id = :lesson_id";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute(['lesson_id' => $lessonId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar capacidad de la clase
    public function updateCapacity($lessonId, $newCapacity) {
        $query = "UPDATE pilates_lessons SET capacity = :capacity WHERE id = :lesson_id";
        $stmt = $this->conexion->prepare($query);
        return $stmt->execute(['capacity' => $newCapacity, 'lesson_id' => $lessonId]);
    }
}
?>