<?php 

require_once "../models/Cita.php";
require_once '../config/database.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $date = $_POST["date"];
    $hour = $_POST["hour"];
    $pilates_type = $_POST["pilates_type"];
    $coach = $_POST["coach"];

    if(empty($date) || empty($hour) || empty($pilates_type) || empty($coach)){
        echo $error = "Todos los campos son obligatorios";
    }else{
        $cita = new Cita($conexion);
        $cita->reservarCita($date, $hour, $pilates_type, $coach);

    }
}

?>