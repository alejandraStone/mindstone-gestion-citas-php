<?php
/*
Archivo que maneja la lista de usuarios en el panel de administración.
Este archivo recibe parámetros de paginación y filtro, obtiene los usuarios de la base de datos y los muestra en una vista.
*/
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/User.php';

$conexion = getPDO();
$userModel = new User($conexion);

// Parámetros de paginación y filtro
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10; // Número de usuarios por página
//limpiar un string de entrada para evitar HTML u otras inyecciones
$search = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';
$role = isset($_GET['role']) ? htmlspecialchars(trim($_GET['role'])) : '';


// Total de usuarios y páginas
$totalUsers = $userModel->countUsers($search, $role);
$totalPages = ceil($totalUsers / $perPage);
$offset = ($page - 1) * $perPage;

// Obtener usuarios
$users = $userModel->getUsers($perPage, $offset, $search, $role);

// Llamo al archivo user_list de la vista y le pasa los datos
require ROOT_PATH . '/app/views/admin/user_list.php';
?>
