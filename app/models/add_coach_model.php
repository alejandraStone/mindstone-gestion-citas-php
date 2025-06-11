<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

class Coach
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Añadir un coach a la bbdd con lógica y formato igual al modelo de clase
    public function addCoach($name, $lastName, $email, $phone, $specialities)
    {
        try {
            $this->conexion->beginTransaction();

            $email = strtolower(trim($email));

            // Verificar si ya existe un coach con ese email
            $check = $this->conexion->prepare("SELECT id FROM coaches WHERE email = :email");
            $check->execute(['email' => $email]);
            if ($check->fetch()) {
                $this->conexion->rollBack();
                return [
                    'success' => false,
                    'message' => 'A coach with this email already exists.'
                ];
            }

            // Insertar coach si no existe
            $query = "INSERT INTO coaches (name, lastName, email, phone)
                      VALUES (:name, :lastName, :email, :phone)";
            $stmt = $this->conexion->prepare($query);
            $success = $stmt->execute([
                'name' => $name,
                'lastName' => $lastName,
                'email' => $email,
                'phone' => $phone
            ]);

            if (!$success) {
                $this->conexion->rollBack();
                return [
                    'success' => false,
                    'message' => 'Unexpected error when adding the coach.'
                ];
            }

            $coach_id = $this->conexion->lastInsertId();

            // Insertar especialidades del coach
            if (is_array($specialities) && count($specialities) > 0) {
                $relation = $this->conexion->prepare(
                    "INSERT INTO coach_speciality (coach_id, speciality_id)
                     VALUES (:coach_id, :speciality_id)"
                );
                foreach ($specialities as $spec_id) {
                    $ok = $relation->execute([
                        'coach_id' => $coach_id,
                        'speciality_id' => $spec_id
                    ]);
                    if (!$ok) {
                        $this->conexion->rollBack();
                        return [
                            'success' => false,
                            'message' => 'Error adding coach specialities.'
                        ];
                    }
                }
            }

            $this->conexion->commit();
            return [
                'success' => true,
                'message' => 'Coach added successfully.'
            ];
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            // Error por duplicado (por índice UNIQUE en email, por ejemplo)
            if ($e->getCode() === '23000') {
                return [
                    'success' => false,
                    'message' => 'A coach with this email already exists.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ];
            }
        }
    }

    // Obtener coaches por especialidad
    public function getBySpeciality($speciality_id)
    {
        $query = "
            SELECT c.id, c.name, c.lastName, c.email, c.phone
            FROM coaches c
            INNER JOIN coach_speciality cs ON c.id = cs.coach_id
            WHERE cs.speciality_id = :speciality_id
        ";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute(['speciality_id' => $speciality_id]);
        $coaches = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Añadir especialidades a cada coach
        foreach ($coaches as &$coach) {
            $coach['specialities'] = $this->getSpecialitiesByCoach($coach['id']);
        }
        return $coaches;
    }

    // Obtener todas las especialidades de un coach (devuelve array de nombres)
    public function getSpecialitiesByCoach($coachId)
    {
        $sql = "SELECT s.name FROM coach_speciality cs
                JOIN pilates_specialities s ON cs.speciality_id = s.id
                WHERE cs.coach_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$coachId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Obtener todos los coaches (con todas sus especialidades)
    public function getAll()
    {
        $sql = "SELECT id, name, lastName, email, phone FROM coaches";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $coaches = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Añadir especialidades a cada coach
        foreach ($coaches as &$coach) {
            $coach['specialities'] = $this->getSpecialitiesByCoach($coach['id']);
        }
        return $coaches;
    }
    public function getById($id)
    {
        try {
            $stmt = $this->conexion->prepare("SELECT * FROM coaches WHERE id = ?");
            $stmt->execute([$id]);
            $coach = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$coach) {
                error_log("Coach with ID $id not found.");
                return null;
            }
            // Suponiendo que tienes que sacar especialities también
            $coach['specialities'] = $this->getSpecialitiesByCoach($id);
            return $coach;
        } catch (PDOException $e) {
            error_log('PDO error in getById: ' . $e->getMessage());
            return null;
        }
    }

    // Devuelve array de IDs de las especialidades de un coach
    public function getSpecialityIdsByCoach($coachId)
    {
        $sql = "SELECT speciality_id FROM coach_speciality WHERE coach_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$coachId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function update($id, $name, $lastName, $email, $phone, $specialities)
    {
        try {
            $this->conexion->beginTransaction();

            // Actualizar datos del coach
            $stmt = $this->conexion->prepare("UPDATE coaches SET name = ?, lastName = ?, email = ?, phone = ? WHERE id = ?");
            $stmt->execute([$name, $lastName, $email, $phone, $id]);

            // Eliminar especialidades anteriores
            $this->conexion->prepare("DELETE FROM coach_speciality WHERE coach_id = ?")->execute([$id]);

            // Insertar nuevas especialidades
            $insert = $this->conexion->prepare("INSERT INTO coach_speciality (coach_id, speciality_id) VALUES (?, ?)");
            foreach ($specialities as $sid) {
                $insert->execute([$id, $sid]);
            }

            $this->conexion->commit();
            return ['success' => true, 'message' => 'Coach updated successfully.'];
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            // Detectar error por email duplicado
            if ($e->getCode() === '23000') {
                return ['success' => false, 'message' => 'This email is already in use by another coach.'];
            }
            return ['success' => false, 'message' => 'Unexpected database error occurred. Please try again later.'];
        }
    }

    public function delete($id)
    {
        try {
            $this->conexion->beginTransaction();

            // Primero eliminar las relaciones con especialidades
            $this->conexion->prepare("DELETE FROM coach_speciality WHERE coach_id = ?")->execute([$id]);

            // Luego eliminar el coach
            $stmt = $this->conexion->prepare("DELETE FROM coaches WHERE id = ?");
            $stmt->execute([$id]);

            $this->conexion->commit();

            return ['success' => true, 'message' => 'Coach deleted successfully.'];
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            return ['success' => false, 'message' => 'Error deleting coach: ' . $e->getMessage()];
        }
    }
}
