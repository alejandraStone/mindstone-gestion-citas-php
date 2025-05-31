<?php
require_once __DIR__ . '/../../config/config.php'; // Define ROOT_PATH y BASE_URL
require_once ROOT_PATH . '/app/config/database.php'; // Carga conexión PDO
require_once ROOT_PATH . '/app/models/User.php'; // Cargar el modelo de usuario
require_once ROOT_PATH . '/app/session/session_manager.php'; // Cargar el gestor de sesiones

// Definir el header para respuesta JSON
header('Content-Type: application/json');

// Inicializar variable de error
$error = "";

// Solo aceptar peticiones POST (AJAX)
if ($_SERVER['REQUEST_METHOD'] == "POST") {
       // Recoger los datos enviados por AJAX
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

    // Validar los campos
    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email format."]);
        exit;
    } else {
        $conexion = getPDO();
        $user = new User($conexion);
        $userData = $user->login($email); // Recupera los datos del usuario

        // Verifica la contraseña
        if ($userData && password_verify($password, $userData['password'])) {
            // Inicia sesión del usuario
            loginUserSession($userData);

            // Devuelve éxito y el rol (puedes usarlo para redirigir en JS)
            echo json_encode([
                "success" => true,
                "role" => $_SESSION['user']['role'],
                "message" => "Login successful!"
            ]);
            exit;
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Incorrect email or password."
            ]);
            exit;
        }
    }
} else {
    // Si no es POST, error
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}
?>