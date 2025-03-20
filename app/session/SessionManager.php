<?php 
session_start();

//verificar si el usuario está autenticado
function isAuthenticated(){
    return isset($_SESSION['user_id']);
}

//obtener datos del usuario autenticado
function getUser(){
    if(isAuthenticated()){
        return[
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'name' => $_SESSION['name']
        ];
    }
    return null;
}

?>