<?php
session_start();
require_once '../config/database.php';
require_once '../models/user.php';
require_once '../session/session_manager.php';


if (!isAuthenticated() || $_SESSION['user']['role'] !== 'admin') {
    header('Location: /login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    //registrar al nuevo admin
    $conexion = getPDO();
    $user = new User($conexion);
    $result = $user->createUser($name, $lastName, $email, $phone, $password, 'admin'); // método con rol explícito

    // Redireccionar según el resultado
    if ($result) {
        header('Location: /admin/dashboard.php?msg=Admin+creado');
    } else {
        header('Location: /admin/dashboard.php?error=No+se+pudo+crear+el+admin');
    }
}
