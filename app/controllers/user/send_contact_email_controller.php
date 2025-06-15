<?php
/*
Archivo que maneja el envío de correos a la empresa que vienen del formulario de contacto.
Se usa phpMailer para enviar correos electrónicos.
 */
require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '/app/helpers/Mailer.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST["name"] ?? '');
    $email   = trim($_POST["email"] ?? '');
    $phone   = trim($_POST["phone"] ?? '');
    $message = trim($_POST["message"] ?? '');

    // Validación básica
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email format."]);
        exit;
    }
//envia el correo usando la función sendContactEmail de Mailer.php
    if (sendContactEmail($email, $name, $phone, $message)) {
        echo json_encode(["success" => true, "message" => "Message sent successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Could not send the message. Please try again later."]);
    }
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}
?>