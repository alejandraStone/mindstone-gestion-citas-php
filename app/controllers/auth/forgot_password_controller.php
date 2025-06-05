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
    // Generar una contraseña segura de 12 caracteres
    function generateSecurePassword($length = 12)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
        $password = '';
        $maxIndex = strlen($chars) - 1;

        // Garantizar que la contraseña tenga al menos una minúscula, una mayúscula, un número y un símbolo
        $password .= $chars[random_int(0, 25)]; // minúscula
        $password .= $chars[random_int(26, 51)]; // mayúscula
        $password .= $chars[random_int(52, 61)]; // número
        $password .= $chars[random_int(62, strlen($chars) - 1)]; // símbolo

        // Completar el resto de la contraseña con caracteres aleatorios
        for ($i = 4; $i < $length; $i++) {
            $password .= $chars[random_int(0, $maxIndex)];
        }

        // Mezclar la contraseña para evitar patrón fijo
        $password = str_shuffle($password);

        return $password;
    }

    // Y aquí la llamada para generar la contraseña segura de 12 caracteres:
    $newPassword = generateSecurePassword(12);

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
