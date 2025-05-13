<?php
require_once '../models/user.php'; //importo el modelo, el que hace las consultas a la DDBB
require_once __DIR__ . '/../config/database.php'; // Asegurar que la conexión esté disponible
require_once '../session/session_manager.php'; //incluir para manejar sesiones


$error = "";
//compruebo que el formulario fue enviado y recogo los datos
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    //valido los inputs, ya que para registrarse es necesario que ingrese todos los datos
    if (empty($email) || empty($password)) {
        echo  $error = "Todos los campos son obligatorios";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //valido el email con la función filter de php
        echo $error = "El email no tiene un formato válido";
    } else {
        $conexion = getPDO();
        $user = new User($conexion);
        $userData = $user->login($email); //recupero los datos del usuario

        if ($userData && password_verify($password, $userData['password'])) { //función de php
            //llamo a la función de sessionMmaneger y obtengo los datos del usuario cuando inicia sesión
            loginUserSession($userData);
            // Redirijo según el rol del usuario
            if ($_SESSION['user']['role'] === 'admin') {
                // Si es admin, lo mando al dashboard
                header("Location: ../views/admin/dashboard.php");
            } else {
                // Si es usuario normal, lo mando a la página de reservas
                header("Location: ../views/book.php");
            }
            exit;
        } else {
            echo $error = "Error usuario o contraseña no válidos.";
        }
    }
}
