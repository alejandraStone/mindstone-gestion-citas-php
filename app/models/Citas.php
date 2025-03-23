<?php 
require_once dirname(__DIR__) . '/config/database.php';

class Cita {
    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    public function reservarCita($date, $hour, $pilates_type, $coach){
        $query = "INSERT INTO citas (date, hour, pilates_type, coach)
        VALUES (:date, :hour, :pilates_type, :coach)";

        $result = $this->conexion->prepare($query);

        return $result->execute([
            'date' => $date,
            'hour' => $hour,
            'pilates_type' => $pilates_type,
            'coach' => $coach
        ]);
    }
}

?>