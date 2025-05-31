<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../config/config.php'; // Define ROOT_PATH y BASE_URL
require_once ROOT_PATH . '/vendor/autoload.php';

function sendPasswordEmail($toEmail, $newPassword)
{
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';           // O tu proveedor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'alejandra.piedra091@gmail.com';   // TU CORREO
        $mail->Password = 'fgxscbwiqeuztucd';        // CONTRASEÑA DE APLICACIÓN
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('alejandra.piedra091@gmail.com', 'MindStone Pilates Center');
        $mail->addAddress($toEmail);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Your new password';
        $mail->Body = "<p>Hello,</p>
                       <p>Your new password is: <strong>$newPassword</strong></p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
        return false;
    }
}
