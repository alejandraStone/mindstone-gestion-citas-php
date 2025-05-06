<?php 

require_once dirname(path: __DIR__) . '/config/database.php';

class Coach{
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    public function addCoach($name, $email, $phone, $start_time, $finish_time, $specialities){
        try{
            //1. insertamos el coach en la tabla coaches
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

        //2. obtengo el ID del coach recién insertado
        $coach_id = $this->conexion->lastInsertId();

        //3. relacionamos el coach con cada especialidad
        $relation_result = $this->conexion->prepare("INSERT INTO coach_speciality(coach_id, speciality_id) VALUES (:coach_id, :speciality_id)");

        //4. recorro la tabla especialidades
        foreach ($specialities as $spec_id) {
            $relation_result->execute([
                'coach_id' => $coach_id,
                'speciality_id' => $spec_id
            ]);
        }

        return true;

    } catch (PDOException $e) {
    // Verificar si el error es por clave duplicada (email único)
        if ($e->getCode() == 23000) {
            return "A coach with this email already exists.";
        }
        return "Error adding coach: " . $e->getMessage();
    }
}
}
?>