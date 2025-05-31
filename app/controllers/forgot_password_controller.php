<?php

require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php'; // Carga conexión PDO
require_once ROOT_PATH . '/app/models/User.php';      // Modelo de usuario

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Llama al método del modelo para actualizar la contraseña
    if (!$user->resetPassword($userData['id'], $newPassword)) {
        echo json_encode(["success" => false, "message" => "Failed to update password in database."]);
        exit;
    }

    // EN DESARROLLO: NO SE ENVÍA MAIL, SINO QUE SE DEVUELVE LA CONTRASEÑA EN EL JSON
    echo json_encode([
        "success" => true,
        "message" => "Password has been reset successfully. Please log in with your new password.",
        "newPassword" => $newPassword
    ]);
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}
?>