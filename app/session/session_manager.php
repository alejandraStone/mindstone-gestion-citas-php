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
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "public/inicio.php");
    exit;
}


?>