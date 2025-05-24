<?php
require_once '../config/database.php';
require_once '../models/lesson.php';


header('Content-Type: application/json'); //para decirle al navegador que se está enviando json

if (isset($_GET['day'])) {
    $day = $_GET['day'];

    $conexion = getPDO();
    $lesson = new Lesson($conexion); // Usa la conexión
    $classes = $lesson->getLessonsByDay($day);

    echo json_encode($classes);
} else {
    echo json_encode(['error' => 'No se proporcionó el día']);
}
