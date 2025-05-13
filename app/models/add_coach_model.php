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

    public function addCoach($name, $email, $phone, $start_time, $finish_time, $specialities)
    {
        try {
            // Iniciar transacción
            $this->conexion->beginTransaction();

            // Normalizar el email a minúsculas
            $email = strtolower(trim($email));

            // Verificar si ya existe un coach con ese email
            $check = $this->conexion->prepare("SELECT id FROM coaches WHERE email = :email");
            $check->execute(['email' => $email]);
            if ($check->fetch()) {
                //si el coach ya existe, no se inserta
                $this->conexion->rollBack();
                return "A coach with this email already exists.";
            }
            // Insertar coach si no existe
            $query = "INSERT INTO coaches (name, email, phone, start_time, finish_time)
                  VALUES (:name, :email, :phone, :start_time, :finish_time)";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'start_time' => $start_time,
                'finish_time' => $finish_time,
            ]);

            // Obtener ID insertado
            $coach_id = $this->conexion->lastInsertId();

            // Insertar especialidades de cada coach para luego mostrarlos en add_class
            $relation = $this->conexion->prepare("INSERT INTO coach_speciality (coach_id, speciality_id)
                                              VALUES (:coach_id, :speciality_id)");
            foreach ($specialities as $spec_id) {
                $relation->execute([
                    'coach_id' => $coach_id,
                    'speciality_id' => $spec_id
                ]);
            }

            if (!is_array($specialities)) {
                $specialities = [];
            }

            // Confirmar todo
            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            return "Database error: " . $e->getMessage();
        }
    }
}
