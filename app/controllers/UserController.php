<?php
//UserController procesa los datos, valida e inserta el usuario en la base de datos
require_once '../models/User.php'; //importo el modelo, el que hace las consultas a la DDBB
require_once __DIR__ . '/../config/database.php'; // Asegurar que la conexión esté disponible
require_once '../session/sessionManager.php';

session_start();

$error = "";
//compruebo que el formulario fue enviado y recogo los datos
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['signup'])) {
    $name = trim($_POST['name']); //elimino los espacios en blanco
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    //valido los inputs, ya que para registrarse es necesario que ingrese todos los datos
    if (empty($name) || empty($lastName) || empty($email) || empty($phone) || empty($password)) {
        echo $error = "Todos los campos son obligatorios";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //valido el email con la función filter de php
        echo $error = "El email no tiene un formato válido";
    } elseif (strlen($password) < 5) { //si es menor de 5 caracteres
        echo $error = "La contraseña debe tener al menos 5 caracteres";
    } elseif (strlen($phone) != 9) {
        echo $error = "El teléfono debe tener 9 dígitos";
    } else {
        var_dump($conexion); //verifico si se pasó la conexión

        //creo un objeto User y le paso la conexión 
        $user = new User($conexion);

        //verifico si el email existe
        if ($user->emailExist($email)) {
            echo $error = "El email ya está registrado";
        } else {
            //guardo el usuario en la DDBB
            if ($user->createUser($name, $lastName, $email, $phone, $password)) {
                $userData = $user->login($email);

                if ($userData) {
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['name'] = $userData['name'];
                    header("Location: ../views/citas.php");
                    exit;
                } else {
                    echo $error = "Error al iniciar sesión después del registro.";
                }
            } else {
                echo $error = "Error al registrar el usuario.";
            }
        }
    }
}
