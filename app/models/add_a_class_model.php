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

    //Función para añadir una clase a la bbdd + generar instancias (4 semanas a partir de hoy)
    public function addLessons($pilates_type, $coach, $capacity, $classEntries)
    {
        try {
            $this->conexion->beginTransaction();

            foreach ($classEntries as $entry) {
                if ($this->classExists($pilates_type, $coach, $entry['day'], $entry['hour'], $capacity)) {
                    $this->conexion->rollBack();
                    return [
                        'success' => false,
                        'message' => 'There is already a class with that type, coach, day and time.'
                    ];
                }
            }

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

                $lessonId = $this->conexion->lastInsertId();

                $this->generateWeeklyInstances($lessonId, $entry['day'], $entry['hour'], $capacity);
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


    // Genera 4 instancias semanales a partir de hoy (incluyendo esta semana)
    private function generateWeeklyInstances($lessonId, $day, $hour, $capacity)
    {
        // Mapa de días (ISO: lunes = 1, domingo = 7)
        $dayMap = [
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6,
            'Sunday' => 7
        ];

        // Validación de día
        $targetDay = $dayMap[$day] ?? null;
        if ($targetDay === null) return;

        // Fecha actual (sin hora)
        $today = new DateTime();
        $today->setTime(0, 0);

        // Ajuste: PHP da 0 = domingo, ISO usa 7 = domingo
        $todayDay = (int)$today->format('w'); // 0-6
        $todayDay = $todayDay === 0 ? 7 : $todayDay;

        // Calcular días hasta el próximo targetDay (incluyendo hoy si coincide)
        $daysUntil = ($targetDay >= $todayDay)
            ? ($targetDay - $todayDay)
            : (7 - $todayDay + $targetDay);

        $firstDate = clone $today;
        $firstDate->modify("+$daysUntil days");

        // Obtener el coach asignado a la clase base
        $stmtCoach = $this->conexion->prepare("SELECT coach FROM pilates_lessons WHERE id = :id");
        $stmtCoach->execute(['id' => $lessonId]);
        $coachId = $stmtCoach->fetchColumn();

        if (!$coachId) return;

        // Preparar inserción de instancias
        $insertStmt = $this->conexion->prepare("
        INSERT INTO class_instances (lesson_id, instance_date, hour, coach_id, capacity)
        VALUES (:lesson_id, :instance_date, :hour, :coach_id, :capacity)
    ");

        // Generar 4 semanas a partir de la fecha calculada
        for ($i = 0; $i < 4; $i++) {
            $date = clone $firstDate;
            $date->modify("+$i week");

            $insertStmt->execute([
                'lesson_id' => $lessonId,
                'instance_date' => $date->format('Y-m-d'),
                'hour' => $hour,
                'coach_id' => $coachId,
                'capacity' => $capacity
            ]);
        }
    }
    // Función para obtener los horarios ocupados de un tipo de pilates y coach específicos
    public function getOccupiedSchedules($pilates_type, $coach)
    {
        $stmt = $this->conexion->prepare(
            "SELECT day, hour FROM pilates_lessons WHERE pilates_type = :type AND coach = :coach"
        );
        $stmt->execute(['type' => $pilates_type, 'coach' => $coach]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Función para obtener todas las lecciones con sus detalles
    public function fetchLessons($selectFields = '*')
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
    public function getAllLessons()
    {
        $fields = "l.id, l.pilates_type, l.coach, l.day, l.hour, l.capacity, 
               s.name AS pilates_type_name, c.name AS coach_name";
        return $this->fetchLessons($fields);
    }
    // Esta función elimina una clase y sus instancias, pero solo si no hay reservas futuras
    public function deleteLesson($id)
    {
        $this->conexion->beginTransaction();

        try {
            // Comprobar si hay reservas futuras
            $stmtCheckBookings = $this->conexion->prepare("
            SELECT COUNT(*) FROM class_reservations r
            INNER JOIN class_instances ci ON r.class_instance_id = ci.id
            WHERE ci.lesson_id = :lesson_id
            AND ci.instance_date >= CURDATE()
        ");
            $stmtCheckBookings->execute(['lesson_id' => $id]);

            if ($stmtCheckBookings->fetchColumn() > 0) {
                return [
                    'success' => false,
                    'message' => 'This class has future bookings and cannot be deleted.'
                ];
            }

            // Eliminar instancias
            $stmtDeleteInstances = $this->conexion->prepare("DELETE FROM class_instances WHERE lesson_id = :id");
            $stmtDeleteInstances->execute(['id' => $id]);

            // Eliminar la clase base
            $stmt = $this->conexion->prepare("DELETE FROM pilates_lessons WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $this->conexion->commit();

            return [
                'success' => true,
                'message' => 'Class deleted successfully.'
            ];
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            return [
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage()
            ];
        }
    }
    // Función para actualizar una clase, permitiendo cambios en coach, capacidad, día y hora
    public function updateLesson($id, $pilates_type, $coach, $capacity, $day, $hour)
    {
        try {
            $this->conexion->beginTransaction();

            // Comprobar si hay reservas futuras asociadas a esta clase
            $stmtCheckBookings = $this->conexion->prepare("
            SELECT COUNT(*) FROM class_reservations r
            INNER JOIN class_instances ci ON r.class_instance_id = ci.id
            WHERE ci.lesson_id = :lesson_id
            AND ci.instance_date >= CURDATE()
        ");
            $stmtCheckBookings->execute(['lesson_id' => $id]);
            $hasBookings = $stmtCheckBookings->fetchColumn() > 0;

            // Obtener datos actuales de la clase
            $stmtCurrent = $this->conexion->prepare("SELECT * FROM pilates_lessons WHERE id = :id");
            $stmtCurrent->execute(['id' => $id]);
            $currentLesson = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

            if (!$currentLesson) {
                $this->conexion->rollBack();
                return [
                    'success' => false,
                    'message' => 'Class not found.'
                ];
            }

            // Si hay reservas, solo se permite cambiar el coach
            if ($hasBookings) {
                $camposRestringidos = [];

                if ($currentLesson['pilates_type'] !== $pilates_type) $camposRestringidos[] = 'class type';
                if ((int)$currentLesson['capacity'] !== (int)$capacity) $camposRestringidos[] = 'capacity';
                if ($currentLesson['day'] !== $day) $camposRestringidos[] = 'day';
                if ($currentLesson['hour'] !== $hour) $camposRestringidos[] = 'hour';

                if (!empty($camposRestringidos)) {
                    $this->conexion->rollBack();
                    return [
                        'success' => false,
                        'message' => 'This class has future bookings and you can only update the coach.'
                    ];
                }
            }

            // Comprobar duplicados
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

            // Actualizar clase
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

            if (!$success) {
                $this->conexion->rollBack();
                return [
                    'success' => false,
                    'message' => 'Failed to update class.'
                ];
            }
            // Si no hay reservas futuras, eliminar instancias futuras y regenerar
            if (!$hasBookings) {
                $stmtDeleteInstances = $this->conexion->prepare(
                    "DELETE FROM class_instances WHERE lesson_id = :lesson_id AND instance_date >= CURDATE()"
                );
                $stmtDeleteInstances->execute(['lesson_id' => $id]);

                $this->generateWeeklyInstances($id, $day, $hour, $capacity);
            }

            $this->conexion->commit();
            return [
                'success' => true,
                'message' => 'Class updated successfully.'
            ];
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            return [
                'success' => false,
                'message' => 'PDO Error Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage()
            ];
        }
    }

    //Función para mostrar todas las clases con ciertos campos AL USUARIO EN INDEX
    // Mostrar todas las instancias de clases para el usuario con sus datos visibles
    public function getAllInstancesForUser()
    {
        // Obtener el lunes de esta semana
        $startOfWeek = new DateTime();
        $startOfWeek->modify('monday this week');
        $start = $startOfWeek->format('Y-m-d');

        // Obtener el domingo de esta semana
        $endOfWeek = new DateTime();
        $endOfWeek->modify('sunday this week');
        $end = $endOfWeek->format('Y-m-d');

        $query = "SELECT 
        i.id, 
        i.lesson_id, 
        i.instance_date AS date, 
        i.hour,
        DAYNAME(i.instance_date) AS day,
        s.name AS pilates_type_name, 
        c.name AS coach_name
      FROM class_instances i
      INNER JOIN pilates_lessons l ON i.lesson_id = l.id
      LEFT JOIN pilates_specialities s ON l.pilates_type = s.id
      LEFT JOIN coaches c ON l.coach = c.id
      WHERE i.instance_date BETWEEN :start AND :end
      ORDER BY i.instance_date ASC, i.hour ASC";

        $stmt = $this->conexion->prepare($query);
        $stmt->execute([
            'start' => $start,
            'end' => $end
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
