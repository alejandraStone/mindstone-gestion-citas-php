<?php 
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php'; 

class Coach {
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    public function addCoach($name, $email, $phone, $start_time, $finish_time, $specialities) {
        try {
            // Comenzamos una transacción
            $this->conexion->beginTransaction();

            // 1. Insertamos el coach en la tabla coaches
            $query = "INSERT INTO coaches (name, email, phone, start_time, finish_time)
                      VALUES (:name, :email, :phone, :start_time, :finish_time)";

            $result = $this->conexion->prepare($query);
            $result->execute([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'start_time' => $start_time,
                'finish_time' => $finish_time,
            ]);

            // 2. Obtengo el ID del coach recién insertado
            $coach_id = $this->conexion->lastInsertId();

            // 3. Relacionamos el coach con cada especialidad
            $relation_result = $this->conexion->prepare("INSERT INTO coach_speciality(coach_id, speciality_id) VALUES (:coach_id, :speciality_id)");

            // 4. Recorremos la tabla especialidades y hacemos la relación
            foreach ($specialities as $spec_id) {
                $relation_result->execute([
                    'coach_id' => $coach_id,
                    'speciality_id' => $spec_id
                ]);
            }

            // Si todo va bien, hacemos commit de la transacción
            $this->conexion->commit();

            return true;

        } catch (PDOException $e) {
            // Si ocurre algún error, hacemos rollback
            $this->conexion->rollBack();

            // Verificamos si el error es por clave duplicada (email único)
            if ($e->getCode() == 23000) {
                return "A coach with this email already exists.";
            }

            // En caso de otros errores, devolvemos un mensaje más detallado
            return "Error adding coach: " . $e->getMessage();
        }
    }
}
?>
