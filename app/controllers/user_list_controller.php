<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/User.php';

$conexion = getPDO();
$userModel = new User($conexion);

// Parámetros de paginación y filtro
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 2; // Número de usuarios por página
$search = $_GET['search'] ?? '';
$role = $_GET['role'] ?? '';

// Total de usuarios y páginas
$totalUsers = $userModel->countUsers($search, $role);
$totalPages = ceil($totalUsers / $perPage);
$offset = ($page - 1) * $perPage;

// Obtener usuarios
$users = $userModel->getUsers($perPage, $offset, $search, $role);

// Llamo al archivo user_list de la vista y le pasa los datos
require ROOT_PATH . '/app/views/admin/user_list.php';
?>
