<?php 

require_once "../models/lesson.php";
require_once '../config/database.php';

//Muestro todas las clases disponibles para reservar

$lessonModel = new Lesson($conexion);
$lessons = $lessonModel->getAllLessons();

echo json_encode($lessons);

?>