<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

class ReservationModel
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Comprueba si hay plazas disponibles para una clase
    public function hasAvailableCapacity(int $lesson_id, ?string &$error = null): bool
    {
        try {
            $stmt = $this->conexion->prepare("SELECT capacity FROM pilates_lessons WHERE id = :lesson_id");
            $stmt->bindValue(':lesson_id', $lesson_id, PDO::PARAM_INT);
            $stmt->execute();
            $capacity = $stmt->fetchColumn();

            if ($capacity === false) {
                $error = "Class not found.";
                return false;
            }

            $stmt2 = $this->conexion->prepare("SELECT COUNT(*) FROM class_reservations WHERE lesson_id = :lesson_id");
            $stmt2->bindValue(':lesson_id', $lesson_id, PDO::PARAM_INT);
            $stmt2->execute();
            $booked = $stmt2->fetchColumn();

            return $booked < $capacity;
        } catch (PDOException $e) {
            $error = "DB error in hasAvailableCapacity: " . $e->getMessage();
            return false;
        }
    }

    // Devuelve los créditos disponibles para un usuario
    public function getAvailableCredits(int $user_id, ?string &$error = null): int
    {
        try {
            $sql = "SELECT COALESCE(SUM(total_credits - used_credits), 0) AS available 
                    FROM credits 
                    WHERE user_id = :user_id AND expires_at > NOW()";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $available = $stmt->fetchColumn();

            return (int)$available;
        } catch (PDOException $e) {
            $error = "DB error in getAvailableCredits: " . $e->getMessage();
            return 0;
        }
    }

    // Intenta reservar una clase utilizando un crédito válido
    public function reserveLessonWithCredit($user_id, $lesson_id, &$error = null): bool
    {
        try {
            // Verificar que el usuario no haya reservado esta clase previamente
            $stmtCheck = $this->conexion->prepare("
            SELECT COUNT(*) FROM class_reservations 
            WHERE user_id = :user_id AND lesson_id = :lesson_id
        ");
            $stmtCheck->execute([
                'user_id' => $user_id,
                'lesson_id' => $lesson_id
            ]);
            if ($stmtCheck->fetchColumn() > 0) {
                $error = "You have already reserved this class.";
                return false;
            }

            // Obtener día y hora de la clase actual
            $stmtLesson = $this->conexion->prepare("
            SELECT day, hour FROM pilates_lessons WHERE id = :lesson_id
        ");
            $stmtLesson->execute(['lesson_id' => $lesson_id]);
            $lesson = $stmtLesson->fetch(PDO::FETCH_ASSOC);

            if (!$lesson) {
                $error = "Class not found.";
                return false;
            }

            // Verificar conflicto de horario con otra clase reservada
            $stmtConflict = $this->conexion->prepare("
            SELECT COUNT(*) FROM class_reservations cr
            JOIN pilates_lessons pl ON cr.lesson_id = pl.id
            WHERE cr.user_id = :user_id AND pl.day = :day AND pl.hour = :hour
        ");
            $stmtConflict->execute([
                'user_id' => $user_id,
                'day' => $lesson['day'],
                'hour' => $lesson['hour']
            ]);

            if ($stmtConflict->fetchColumn() > 0) {
                $error = "You already have a reservation at this time.";
                return false;
            }

            // Verificar capacidad
            if (!$this->hasAvailableCapacity($lesson_id, $error)) {
                if (!$error) $error = "No more available spots.";
                return false;
            }

            // Inicia la transacción
            $this->conexion->beginTransaction();

            // Obtener crédito activo
            $sql = "SELECT id FROM credits 
                WHERE user_id = :user_id AND (total_credits - used_credits) > 0 AND expires_at > NOW() 
                ORDER BY created_at ASC LIMIT 1";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $credit_id = $stmt->fetchColumn();

            if (!$credit_id) {
                $error = "No active credits available.";
                $this->conexion->rollBack();
                return false;
            }

            // Insertar reserva
            $insert = $this->conexion->prepare("INSERT INTO class_reservations (user_id, lesson_id, credit_used) VALUES (:user_id, :lesson_id, 1)");
            $insert->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $insert->bindValue(':lesson_id', $lesson_id, PDO::PARAM_INT);
            $insert->execute();

            // Actualizar crédito
            $update = $this->conexion->prepare("UPDATE credits SET used_credits = used_credits + 1 WHERE id = :credit_id");
            $update->bindValue(':credit_id', $credit_id, PDO::PARAM_INT);
            $update->execute();

            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            $error = "DB error in reserveLessonWithCredit: " . $e->getMessage();
            return false;
        }
    }
}
