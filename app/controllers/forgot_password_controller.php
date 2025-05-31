<?php

require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php'; // Conexión PDO
require_once ROOT_PATH . '/app/models/User.php';    // Modelo de usuario
require_once ROOT_PATH . '/app/helpers/Mailer.php'; // PHPMailer

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST["forgot_email"] ?? '');

    if (empty($email)) {
        echo json_encode(["success" => false, "message" => "Email is required."]);
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email format."]);
        exit;
    }

    $conexion = getPDO();
    $user = new User($conexion);
    $userData = $user->getUserByEmail($email);

    if (!$userData) {
        echo json_encode(["success" => false, "message" => "Email not found."]);
        exit;
    }

    // Generar nueva contraseña aleatoria
    $newPassword = bin2hex(random_bytes(4));

    // Actualizar la contraseña en la base de datos
    if (!$user->resetPassword($userData['id'], $newPassword)) {
        echo json_encode(["success" => false, "message" => "Failed to update password in database."]);
        exit;
    }

    // Enviar la nueva contraseña por correo
    if (!sendPasswordEmail($email, $newPassword)) {
        echo json_encode(["success" => false, "message" => "Password updated but email could not be sent."]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "message" => "Password has been reset and sent to your email."
    ]);
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}
