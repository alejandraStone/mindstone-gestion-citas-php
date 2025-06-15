<?php

// Inicia sesión si aún no existe
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once realpath(__DIR__ . '/../config/config.php');


//Verifica si el usuario está autenticado (existe en la sesión)
function isAuthenticated() {
    return isset($_SESSION['user']);
}

//Obtiene los datos del usuario autenticado
function getUser() {
    return isAuthenticated() ? $_SESSION['user'] : null;
}

//Inicia la sesión del usuario, guardando sus datos básicos
function loginUserSession($userData) {

    //session_regenerate_id(true); en un futuro se puede renegar el ID de sesión si se desea para evitar ataques de fijación de sesión
    $_SESSION['user'] = [
        'id'    => $userData['id'] ?? null,
        'email' => $userData['email'] ?? null,
        'name'  => $userData['name'] ?? null,
        'role'  => $userData['role'] ?? 'user'
    ];
}

//Cierra la sesión del usuario y redirige al inicio
 function logoutUserSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Limpia todas las variables de sesión
    $_SESSION = [];
    session_unset();

    // Borra la cookie de sesión si existe
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destruye la sesión
    session_destroy();

    // Redirige a la página de inicio
    header("Location: " . BASE_URL . "public/inicio.php");
    exit;
}

?>