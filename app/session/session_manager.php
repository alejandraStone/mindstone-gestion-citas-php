<?php 
require_once realpath(__DIR__ . '/../config/config.php');


if (session_status() === PHP_SESSION_NONE) {//si la sesión no está activa devuelve session none
    session_start();
}
//verificar si el usuario está autenticado
function isAuthenticated(){
    return isset($_SESSION['user']);
}

//obtener datos del usuario autenticado
function getUser(){
    if(isAuthenticated()){
    return $_SESSION['user'] ?? null;

    }
    return null;
}

//inicia sesión con los datos del usuario
function loginUserSession($userData){
    $_SESSION['user'] = [
    'id'    => $userData['id'],
    'email' => $userData['email'],
    'name'  => $userData['name'],
    'role'  => $userData['role'] ?? 'user'//user por defecto
     ];
}

function logoutUserSession(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Limpia todas las variables de sesión
    $_SESSION = [];

    // Borra la cookie de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destruye la sesión
    session_destroy();

    // Redirige a inicio
    header("Location: " . BASE_URL . "public/inicio.php");
    exit;
}



?>