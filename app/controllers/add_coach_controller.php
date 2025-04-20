<?php 
require_once "../models/add_coach_model.php";
require_once '../config/database.php';

$error = "";
$success = "";

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $start_time = $_POST["start_time"];
    $finish_time = $_POST["finish_time"];
    $specialities = $_POST['speciality'] ?? [];

    if (empty($name) || empty($email) || empty($phone) || empty($start_time) || empty($finish_time) || empty($specialities)) {
        $error = "All fields are required.";
        header("Location: /mindStone/public/views/add_coach_view.php?error=" . urlencode($error));
        exit;
    }
    
    $coach = new Coach($conexion);
    $result = $coach->addCoach($name, $email, $phone, $start_time, $finish_time, $specialities);

    if ($result === true) {
        $success = "Coach successfully added.";
        header("Location: /mindStone/public/views/add_coach_view.php?success=" . urlencode($success));
    } else {
        // Si $result devuelve un mensaje de error del modelo, lo mostramos
        header("Location: /mindStone/public/views/add_coach_view.php?error=" . urlencode($result));
    }
    exit;
}
?>