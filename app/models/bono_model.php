<?php
/*
Archivo que define la clase Bonus para manejar operaciones relacionadas con los bonos en la base de datos.
*/
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

class Bonus
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Obtener todos los bonos activos
    public function getAllBonos()
    {
        try {
            $query = "SELECT * FROM bonos WHERE activo = 1 ORDER BY id ASC";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute();
            return [
                'success' => true,
                'bonos' => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ];
        } catch (PDOException $e) {
            error_log("Error en getAllBonos: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error fetching bonus list.'
            ];
        }
    }

    // Obtener todos los bonos incluyendo inactivos (opcional para admin)
    public function getAllBonosIncluyendoInactivos()
    {
        try {
            $query = "SELECT * FROM bonos ORDER BY id ASC";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getAllBonosIncluyendoInactivos: " . $e->getMessage());
            return [];
        }
    }

    // Obtener bono por ID
    public function getBonusById($id)
    {
        try {
            $stmt = $this->conexion->prepare("SELECT * FROM bonos WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $bonus = $stmt->fetch(PDO::FETCH_ASSOC);
            return $bonus ?: null;
        } catch (PDOException $e) {
            error_log("Error en getBonusById: " . $e->getMessage());
            return null;
        }
    }

    // Crear un bono nuevo (en un futuro utilizaré esta función para crear bonos desde el panel de administración)
    public function createBonus($name, $description, $price, $credits)
    {
        try {
            $stmt = $this->conexion->prepare("INSERT INTO bonos (name, description, price, credits, activo) VALUES (?, ?, ?, ?, 1)");
            $stmt->execute([$name, $description, $price, $credits]);
            $bonusId = $this->conexion->lastInsertId();
            return [
                'success' => true,
                'message' => 'Bonus created successfully.',
                'bonus_id' => $bonusId
            ];
        } catch (PDOException $e) {
            error_log("Error en createBonus: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error creating bonus.'
            ];
        }
    }

    // Eliminar bono
    public function deleteBonus($id)
    {
        try {
            $stmt = $this->conexion->prepare("DELETE FROM bonos WHERE id = ?");
            $stmt->execute([$id]);
            return [
                'success' => true,
                'message' => 'Bonus deleted successfully.'
            ];
        } catch (PDOException $e) {
            error_log("Error en deleteBonus: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error deleting bonus.'
            ];
        }
    }

    // Actualizar bono
    public function updateBonus($id, $name, $description, $price, $credits)
    {
        try {
            $stmt = $this->conexion->prepare("UPDATE bonos SET name = ?, description = ?, price = ?, credits = ? WHERE id = ?");
            $stmt->execute([$name, $description, $price, $credits, $id]);
            return [
                'success' => true,
                'message' => 'Bonus updated successfully.'
            ];
        } catch (PDOException $e) {
            error_log("Error en updateBonus: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error updating bonus.'
            ];
        }
    }

    // Activar o desactivar bono (soft delete o visibilidad)
    public function setBonusActivo($id, $estado)
    {
        try {
            $stmt = $this->conexion->prepare("UPDATE bonos SET activo = ? WHERE id = ?");
            $stmt->execute([$estado, $id]);
            return [
                'success' => true,
                'message' => 'Bonus visibility updated.'
            ];
        } catch (PDOException $e) {
            error_log("Error en setBonusActivo: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error updating visibility.'
            ];
        }
    }

    // Registrar compra de bono
    public function createPurchase($userId, $bonusId, $price, $validUntil, $stripeSessionId, $credits)
    {
        try {
            $stmt = $this->conexion->prepare("
            INSERT INTO purchases (user_id, bonus_id, price, valid_until, stripe_session_id, credits)
            VALUES (:user_id, :bonus_id, :price, :valid_until, :stripe_session_id, :credits)
        ");
            $stmt->execute([
                'user_id' => $userId,
                'bonus_id' => $bonusId,
                'price' => $price,
                'valid_until' => $validUntil,
                'stripe_session_id' => $stripeSessionId,
                'credits' => $credits
            ]);
            return [
                'success' => true,
                'purchase_id' => $this->conexion->lastInsertId()
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    // Verificar si una compra ya existe por ID de sesión de Stripe
    public function purchaseExistsBySessionId(string $sessionId): bool
    {
        try {
            $stmt = $this->conexion->prepare("SELECT id FROM purchases WHERE stripe_session_id = :session_id LIMIT 1");
            $stmt->execute(['session_id' => $sessionId]);
            return (bool) $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error checking purchase existence: " . $e->getMessage());
            return false;
        }
    }

    //Asignar los créditos del bono al usuario
    public function assignCredits($userId, $purchaseId, $credits, $expiresAt)
    {
        try {
            $stmt = $this->conexion->prepare("
            INSERT INTO credits (user_id, purchase_id, total_credits, used_credits, expires_at)
            VALUES (:user_id, :purchase_id, :total_credits, 0, :expires_at)
        ");
            $stmt->execute([
                'user_id' => $userId,
                'purchase_id' => $purchaseId,
                'total_credits' => $credits,
                'expires_at' => $expiresAt
            ]);
            return [
                'success' => true,
                'message' => 'Credits assigned successfully.'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    // Obtener los bonos comprados por un usuario
    public function getUserCredits(int $user_id): array
    {
        try {
            $sql = "SELECT 
                    total_credits,
                    used_credits,
                    expires_at
                FROM credits
                WHERE user_id = :user_id
                AND expires_at > NOW()
                ORDER BY expires_at ASC";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            $credits = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'data' => $credits
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
}
