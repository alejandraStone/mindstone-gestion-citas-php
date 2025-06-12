<?php

require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/lesson.php';


//Muestro al admin todas las clases disponibles para reservar

$conexion = getPDO();
$lessonModel = new Lesson($conexion);
$lessons = $lessonModel->getAllLessons();

echo json_encode($lessons);
