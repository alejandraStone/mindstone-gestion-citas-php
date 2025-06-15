<?php
/*
Archivo que maneja la carga de archivos PDF por parte de un administrador.
Este archivo recibe un archivo PDF y una descripción, valida el archivo y lo guarda en el servidor
*/
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/session/session_manager.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/upload_files_model.php'; // Cargar el modelo de archivos

// Verificar si el usuario está autenticado y es un administrador

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . 'public/inicio.php');
    exit;
}

$error = '';
$success = '';
$conexion = getPDO();
$pdfModel = new PDFModel($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
        $error = "You must select a valid PDF file.";
    } else {
        $file = $_FILES['pdf_file'];
        $description = trim($_POST['description'] ?? '');

        $allowedMime = 'application/pdf';
        $maxSize = 2 * 1024 * 1024; // 2MB

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if ($mime !== $allowedMime) {
            $error = "The file must be a PDF.";
        } elseif ($file['size'] > $maxSize) {
            $error = "The file is too large (max 2MB).";
        } elseif (empty($description)) {
            $error = "Description is mandatory.";
        } else {
            // Guardar el archivo
            $uploadDir = ROOT_PATH . '/app/uploads/pdfs/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
            $newFileName = uniqid('pdf_', true) . '.pdf';
            $destination = $uploadDir . $newFileName;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                // Guardar info en la base de datos
                $relativePath = '/app/uploads/pdfs/' . $newFileName;
                $pdfModel->savePDF($relativePath, $description, $_SESSION['user']['id']);
                $success = "File uploaded successfully.";
            } else {
                $error = "Error when moving the file to the server.";
            }
        }
    }
}
// SIEMPRE obtener los PDFs para la tabla:
$pdfs = $pdfModel->getAllPDFs();
// Mostrar la vista
require ROOT_PATH . '/app/views/admin/upload_files.php';
