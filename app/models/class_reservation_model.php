<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

class ClassReservation
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    // Método para crear una reserva de clase
    public function createReservation($userId, $classInstanceId)
    {
        try {
            $this->conexion->beginTransaction();

            // 1. Verificar si ya hay reserva activa para esa clase (no permitimos duplicados)
            $stmtCheckActive = $this->conexion->prepare(
                "SELECT id FROM class_reservations 
             WHERE user_id = :user_id AND class_instance_id = :class_instance_id AND is_cancelled = FALSE"
            );
            $stmtCheckActive->execute(['user_id' => $userId, 'class_instance_id' => $classInstanceId]);
            if ($stmtCheckActive->fetch()) {
                $this->conexion->rollBack();
                return ['success' => false, 'message' => 'You have already reserved this class.'];
            }

            // 2. Obtener info de la clase para validar fecha y capacidad
            $stmtClass = $this->conexion->prepare(
                "SELECT capacity, instance_date, hour FROM class_instances WHERE id = :class_instance_id FOR UPDATE"
            );
            $stmtClass->execute(['class_instance_id' => $classInstanceId]);
            $classInstance = $stmtClass->fetch(PDO::FETCH_ASSOC);
            if (!$classInstance) {
                $this->conexion->rollBack();
                return ['success' => false, 'message' => 'Class instance does not exist.'];
            }

            // Construir DateTime de la clase
            $classDateTimeStr = $classInstance['instance_date'] . ' ' . $classInstance['hour'];
            $classDate = new DateTime($classDateTimeStr);
            $now = new DateTime();
            if ($classDate < $now) {
                $this->conexion->rollBack();
                return ['success' => false, 'message' => 'Cannot reserve a class in the past.'];
            }

            // 3. Contar reservas activas para validar capacidad
            $stmtCount = $this->conexion->prepare(
                "SELECT COUNT(*) FROM class_reservations WHERE class_instance_id = :class_instance_id AND is_cancelled = FALSE"
            );
            $stmtCount->execute(['class_instance_id' => $classInstanceId]);
            $reservedCount = (int)$stmtCount->fetchColumn();

            if ($reservedCount >= $classInstance['capacity']) {
                $this->conexion->rollBack();
                return ['success' => false, 'message' => 'Class is fully booked.'];
            }

            // 4. Verificar si hay reserva cancelada previa para reactivar
            $stmtCheckCancelled = $this->conexion->prepare(
                "SELECT id FROM class_reservations 
             WHERE user_id = :user_id AND class_instance_id = :class_instance_id AND is_cancelled = TRUE"
            );
            $stmtCheckCancelled->execute(['user_id' => $userId, 'class_instance_id' => $classInstanceId]);
            $cancelledReservation = $stmtCheckCancelled->fetch(PDO::FETCH_ASSOC);

            // 5. Buscar crédito activo válido (con lock FOR UPDATE)
            $stmtCredit = $this->conexion->prepare(
                "SELECT id, total_credits, used_credits FROM credits 
             WHERE user_id = :user_id AND expires_at >= NOW() AND (total_credits - IFNULL(used_credits,0)) > 0
             ORDER BY expires_at ASC LIMIT 1
             FOR UPDATE"
            );
            $stmtCredit->execute(['user_id' => $userId]);
            $credit = $stmtCredit->fetch(PDO::FETCH_ASSOC);

            if (!$credit) {
                $this->conexion->rollBack();
                return ['success' => false, 'message' => 'No active credits available. Please buy a credit pack.'];
            }

            // 6. Descontar un crédito (usar 1 crédito)
            $stmtUpdateCredit = $this->conexion->prepare(
                "UPDATE credits SET used_credits = used_credits + 1 WHERE id = :credit_id"
            );
            $stmtUpdateCredit->execute(['credit_id' => $credit['id']]);

            // 7. Reactivar reserva cancelada o insertar reserva nueva
            if ($cancelledReservation) {
                $stmtReactivate = $this->conexion->prepare(
                    "UPDATE class_reservations 
                 SET is_cancelled = FALSE, reserved_at = NOW(), used_credit_id = :credit_id 
                 WHERE id = :reservation_id"
                );
                $stmtReactivate->execute([
                    'credit_id' => $credit['id'],
                    'reservation_id' => $cancelledReservation['id']
                ]);
            } else {
                $stmtInsert = $this->conexion->prepare(
                    "INSERT INTO class_reservations (user_id, class_instance_id, reserved_at, used_credit_id)
                 VALUES (:user_id, :class_instance_id, NOW(), :used_credit_id)"
                );
                $stmtInsert->execute([
                    'user_id' => $userId,
                    'class_instance_id' => $classInstanceId,
                    'used_credit_id' => $credit['id']
                ]);
            }

            $this->conexion->commit();

            return ['success' => true, 'message' => 'Reservation created successfully.'];
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return ['success' => false, 'message' => 'Unexpected error: ' . $e->getMessage()];
        }
    }
    // Método para cancelar una reserva
    public function cancelReservation(int $reservationId, int $userId): array
    {
        try {
            $this->conexion->beginTransaction();

            // 1. Obtener info de la reserva para validar hora y obtener class_instance_id + used_credit_id
            $sql = "SELECT ci.instance_date, ci.hour, cr.class_instance_id, cr.used_credit_id
                FROM class_reservations cr
                JOIN class_instances ci ON cr.class_instance_id = ci.id
                WHERE cr.id = :reservation_id AND cr.user_id = :user_id AND cr.is_cancelled = FALSE";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([':reservation_id' => $reservationId, ':user_id' => $userId]);
            $instance = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$instance) {
                $this->conexion->rollBack();
                return [
                    'success' => false,
                    'message' => 'Reservation not found, already cancelled or access denied.',
                ];
            }

            // 2. Validar cancelación (3h antes)
            $datetimeStr = $instance['instance_date'] . ' ' . $instance['hour'];
            $classDateTime = new DateTime($datetimeStr);
            $now = new DateTime();

            $diff = $now->diff($classDateTime);
            $hoursDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);
            if ($diff->invert === 1 || $hoursDiff < 3) {
                $this->conexion->rollBack();
                return [
                    'success' => false,
                    'message' => 'You cannot cancel a reservation less than 3 hours before the class.',
                ];
            }

            // 3. Marcar la reserva como cancelada
            $sqlCancel = "UPDATE class_reservations SET is_cancelled = TRUE WHERE id = :reservation_id AND user_id = :user_id";
            $stmtCancel = $this->conexion->prepare($sqlCancel);
            $stmtCancel->execute([':reservation_id' => $reservationId, ':user_id' => $userId]);

            if ($stmtCancel->rowCount() === 0) {
                $this->conexion->rollBack();
                return [
                    'success' => false,
                    'message' => 'Reservation cancellation failed.',
                ];
            }

            // 4. Devolver crédito al usuario usando el used_credit_id correcto
            if (!empty($instance['used_credit_id'])) {
                $sqlUpdateCredit = "UPDATE credits SET used_credits = used_credits - 1 WHERE id = :credit_id";
                $stmtUpdateCredit = $this->conexion->prepare($sqlUpdateCredit);
                $stmtUpdateCredit->execute([':credit_id' => $instance['used_credit_id']]);
            }

            // 5. NO tocar la capacidad fija en class_instances

            $this->conexion->commit();

            return [
                'success' => true,
                'message' => 'Reservation cancelled successfully and credit refunded.',
            ];
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return [
                'success' => false,
                'message' => 'Unexpected error.',
                'dev_message' => $e->getMessage(),
            ];
        }
    }
    // Método para obtener las reservas de un usuario con paginación opcional
    public function getUserReservations(int $user_id, int $limit = null, int $offset = null): array
    {
        try {
            $sql = "SELECT 
                    r.id AS reservation_id,
                    ci.instance_date,
                    ci.hour,
                    ci.capacity,
                    ps.name AS pilates_type,
                    c.name AS coach_name,
                    r.reserved_at,
                    r.used_credit_id,
                    r.is_cancelled
                FROM class_reservations r
                JOIN class_instances ci ON r.class_instance_id = ci.id
                JOIN pilates_lessons pl ON ci.lesson_id = pl.id
                JOIN pilates_specialities ps ON pl.pilates_type = ps.id
                JOIN coaches c ON ci.coach_id = c.id
                WHERE r.user_id = :user_id
                ORDER BY ci.instance_date ASC, ci.hour ASC";

            // Agrega paginación si se solicita
            if ($limit !== null && $offset !== null) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

            if ($limit !== null && $offset !== null) {
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            }

            $stmt->execute();
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Total solo si hay paginación (para UI)
            $total = null;
            if ($limit !== null && $offset !== null) {
                $countStmt = $this->conexion->prepare("SELECT COUNT(*) FROM class_reservations WHERE user_id = :user_id");
                $countStmt->execute(['user_id' => $user_id]);
                $total = $countStmt->fetchColumn();
            }

            return [
                'success' => true,
                'data' => $reservations,
                'total' => $total
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    //obtener el total de reservas hechas en el mes
    public function countReservationsInMonth(int $year, int $month): array
    {
        try {
            $startDate = new DateTime("$year-$month-01");
            $endDate = clone $startDate;
            $endDate->modify('last day of this month');

            $sql = "SELECT COUNT(*) FROM class_reservations r
                JOIN class_instances ci ON r.class_instance_id = ci.id
                WHERE ci.instance_date BETWEEN :start_date AND :end_date
                  AND r.is_cancelled = FALSE";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':start_date' => $startDate->format('Y-m-d'),
                ':end_date' => $endDate->format('Y-m-d')
            ]);
            $count = (int) $stmt->fetchColumn();

            return ['success' => true, 'count' => $count];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
    // Método para obtener el crecimiento mensual de reservas
    function getMonthlyReservationGrowth(PDO $pdo): array {
    // Obtenemos reservas para este mes y el mes anterior
    $sql = "SELECT 
                YEAR(reserved_at) AS year, 
                MONTH(reserved_at) AS month, 
                COUNT(*) AS total_reservations
            FROM class_reservations
            WHERE is_cancelled = FALSE
              AND reserved_at >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH)
            GROUP BY year, month
            ORDER BY year DESC, month DESC
            LIMIT 2";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) < 2) {
        return [
            'success' => true,
            'growth_percentage' => 0,
            'message' => 'Not enough data to calculate growth.'
        ];
    }

    // Asumimos que la primera fila es mes actual, segunda mes anterior
    $currentMonth = $results[0]['total_reservations'];
    $previousMonth = $results[1]['total_reservations'];

    if ($previousMonth == 0) {
        // Evitamos división por cero
        $growth = $currentMonth > 0 ? 100 : 0;
    } else {
        $growth = (($currentMonth - $previousMonth) / $previousMonth) * 100;
    }

    return [
        'success' => true,
        'growth_percentage' => round($growth, 2),
        'message' => 'Monthly growth calculated.'
    ];
}

}
