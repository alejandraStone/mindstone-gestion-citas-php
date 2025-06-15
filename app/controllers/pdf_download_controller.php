<?php
/*
Archivo que maneja la descarga de archivos PDF subidos por el administrador.
Este archivo recibe un ID de PDF por GET, verifica permisos y devuelve el archivo para descarga.
*/
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/session/session_manager.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/upload_files_model.php';

// 1. Verifica permisos (solo admin)
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    exit('No autorizado.');
}

// 2. Verifica que venga el id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    exit('Petición incorrecta.');
}

$conexion = getPDO();
$pdfModel = new PDFModel($conexion);
$id = (int)$_GET['id'];

/// 3. Busca el PDF en la base de datos usando el modelo
$pdf = $pdfModel->getPDFById($id);

if (!$pdf) {
    http_response_code(404);
    exit('Archivo no encontrado.');
}

// 4. Obtén el path real del archivo (ajusta si está fuera de public)
$filePath = ROOT_PATH . $pdf['file_path'];
if (!file_exists($filePath)) {
    http_response_code(404);
    exit('Archivo no encontrado en servidor.');
}

// 5. Envía el archivo con headers correctos para descarga
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
header('Content-Length: ' . filesize($filePath));
readfile($filePath);
exit;