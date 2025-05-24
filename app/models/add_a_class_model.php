<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

class Lesson
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    //Función para verificar si una clase ya existe en la bbdd. Se le pasa el tipo de pilates, el coach, el día, la hora y la capacidad
    // Se le puede pasar un id para excluirlo de la búsqueda (en caso de editar una clase)
    private function classExists($pilates_type, $coach, $day, $hour, $capacity, $excludeId = null)
    {
        $query = "SELECT COUNT(*) FROM pilates_lessons 
              WHERE pilates_type = :pilates_type 
              AND coach = :coach 
              AND day = :day 
              AND hour = :hour 
              AND capacity = :capacity";

        if ($excludeId !== null) {
            $query .= " AND id != :exclude_id";
        }

        $stmt = $this->conexion->prepare($query);
        $params = [
            'pilates_type' => $pilates_type,
            'coach' => $coach,
            'day' => $day,
            'hour' => $hour,
            'capacity' => $capacity
        ];

        if ($excludeId !== null) {
            $params['exclude_id'] = $excludeId;
        }

        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    //Función para añadir una clase a la bbdd. Se le pasa el tipo de pilates, el coach, la capacidad y un array con los días y horas
    public function addLessons($pilates_type, $coach, $capacity, $classEntries)
    {
        try {
            $this->conexion->beginTransaction();

            // Validar duplicados
            foreach ($classEntries as $entry) {
                // Verificar si la clase ya existe
                if ($this->classExists($pilates_type, $coach, $entry['day'], $entry['hour'], $capacity)) {
                    $this->conexion->rollBack();
                    return [
                        'success' => false,
                        'message' => 'There is already a class with that type, coach, day and time.'
                    ];
                }
            }
            // Si no, insertar clases
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
            return [
                'success' => false,
                'message' => $e->getCode() === '23000'
                    ? 'There is already a class with that type, coach, day and time.'
                    : 'Unexpected error when adding the class.'
            ];
        }
    }
    //Función para consultar los días y horas que una clase ha sido añadida.
    public function getOccupiedSchedules($pilates_type, $coach)
    {
        $stmt = $this->conexion->prepare(
            "SELECT day, hour FROM pilates_lessons WHERE pilates_type = :type AND coach = :coach"
        );
        $stmt->execute(['type' => $pilates_type, 'coach' => $coach]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //Función para consultar las clases que están publicadas en la bbdd
    private function fetchLessons($selectFields = '*')
    {
        $query = "SELECT $selectFields
                    FROM pilates_lessons l
                    LEFT JOIN pilates_specialities s ON l.pilates_type = s.id
                    LEFT JOIN coaches c ON l.coach = c.id
                    ORDER BY l.day, l.hour";


        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //Función para mostrar todas las clases que hay en la bbdd AL ADMIN EN DASHBOARD
    public function getAllLessons()
    {
        $fields = "l.id, l.pilates_type, l.coach, l.day, l.hour, l.capacity, 
               s.name AS pilates_type_name, c.name AS coach_name";
        return $this->fetchLessons($fields);
    }
    //Función para mostrar todas las clases con cierto campos AL USUARIO EN INDEX
    public function getAllLessonsForUser()
    {
        $fields = "l.day, l.hour, s.name AS pilates_type_name, c.name AS coach_name";
        return $this->fetchLessons($fields);
    }

    //Función para borrar una clase de la bbdd
    public function deleteLesson($id)
    {
        $stmt = $this->conexion->prepare("DELETE FROM pilates_lessons WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    //Función para editar o hacer update de una clase ya añadida con validación de duplicados
    public function updateLesson($id, $pilates_type, $coach, $capacity, $day, $hour)
    {
        try {
            $this->conexion->beginTransaction();

            // Verificar si ya existe una clase con esos mismos datos (excepto este ID)
            $query = "SELECT COUNT(*) FROM pilates_lessons 
                  WHERE pilates_type = :pilates_type AND coach = :coach 
                  AND day = :day AND hour = :hour AND id != :id";
            $stmtCheck = $this->conexion->prepare($query);
            $stmtCheck->execute([
                'pilates_type' => $pilates_type,
                'coach' => $coach,
                'day' => $day,
                'hour' => $hour,
                'id' => $id
            ]);

            if ($stmtCheck->fetchColumn() > 0) {
                $this->conexion->rollBack();
                return [
                    'success' => false,
                    'message' => 'There is already a class with that type, coach, day and time.'
                ];
            }

            $stmt = $this->conexion->prepare(
                "UPDATE pilates_lessons
             SET pilates_type = :pilates_type,
                 coach = :coach,
                 capacity = :capacity,
                 day = :day,
                 hour = :hour
             WHERE id = :id"
            );

            $success = $stmt->execute([
                'id' => $id,
                'pilates_type' => $pilates_type,
                'coach' => $coach,
                'capacity' => $capacity,
                'day' => $day,
                'hour' => $hour
            ]);

            if ($success) {
                $this->conexion->commit();
                return [
                    'success' => true,
                    'message' => 'Class updated successfully.'
                ];
            } else {
                $this->conexion->rollBack();
                return [
                    'success' => false,
                    'message' => 'Failed to update class.'
                ];
            }
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            return [
                'success' => false,
                'message' => $e->getCode() === '23000'
                    ? 'There is already a class with that type, coach, day and time.'
                    : 'Unexpected error when updating the class.'
            ];
        }
    }
}
