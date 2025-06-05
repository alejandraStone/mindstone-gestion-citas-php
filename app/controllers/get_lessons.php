<?php

require_once "../models/lesson.php";
require_once '../config/database.php';

//Muestro al admin todas las clases disponibles para reservar

$conexion = getPDO();
$lessonModel = new Lesson($conexion);
$lessons = $lessonModel->getAllLessons();

echo json_encode($lessons);
