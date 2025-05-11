<?php 
if (session_status() === PHP_SESSION_NONE) {//si la sesión no está activa devuelve session none
    session_start();
}
//verificar si el usuario está autenticado
function isAuthenticated(){
    return isset($_SESSION['user_email']);
}

//obtener datos del usuario autenticado
function getUser(){
    if(isAuthenticated()){
        return[
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'name' => $_SESSION['name'] ?? 'Guest', //para evitar errores
        ];
    }
    return null;
}

function loginUserSession($userData){
    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['user_email'] = $userData['email'];
    $_SESSION['name'] = $userData['name'];
}

function logoutUserSession(){
    session_unset();
    session_destroy();
}


?>