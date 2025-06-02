<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../config/config.php'; // Define ROOT_PATH y BASE_URL
require_once ROOT_PATH . '/vendor/autoload.php';

function sendPasswordEmail($toEmail, $newPassword)
{
    $mail = new PHPMailer(true);

    try {
        // Activar SMTP
        $mail->isSMTP();

        // Configuración del servidor SMTP
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->SMTPSecure = $_ENV['SMTP_SECURE'];


        // Remitente y destinatario
        $mail->setFrom('alejandra.piedra091@gmail.com', 'MindStone Pilates Center');
        $mail->addAddress($toEmail);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Your new password';
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; color: #333; background-color: #f9f9f9; border: 1px solid #ddd;">
            <h2 style="color: #4a6d91;">MindStone Pilates Center</h2>
            <p>Hi there,</p>
            <p>You have requested to reset your password. Please use the new password to log in:</p>
            <p style="font-size: 18px; font-weight: bold; background-color: #e1ecf4; padding: 10px; display: inline-block; border-radius: 5px; color: #2c3e50;">' . $newPassword . '</p>
            <hr style="margin-top: 30px; border: none; border-top: 1px solid #ccc;">
            <p style="font-size: 12px; color: #777;">If you did not request this change, please ignore this email or contact our support team.</p>
            <p style="font-size: 12px; color: #777;">&copy; ' . date("Y") . ' MindStone Pilates Center</p>
        </div>
        ';

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
        return false;
    }
}
