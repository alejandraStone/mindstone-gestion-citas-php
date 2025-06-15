<?php
//Archivo que maneja el cierre de sesión del usuario
// Este archivo incluye la lógica para cerrar la sesión del usuario y redirigirlo a la página de inicio de sesión.

// session/logout.php
require_once __DIR__ . '/session_manager.php';

logoutUserSession();
?>
!