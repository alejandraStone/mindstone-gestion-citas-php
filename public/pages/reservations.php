<?php
require_once __DIR__ . '/../../app/config/config.php';
require_once ROOT_PATH . '/app/session/session_manager.php';


// Si el usuario no está autenticado, lo mandamos al inicio
if (!isAuthenticated()) {
    header("Location: " . BASE_URL . "public/inicio.php");
    exit;
}

// Aquí podrías cargar datos si tuvieras un controlador de reservas
// require_once __DIR__ . '/../app/controllers/ReservationsController.php';
// $controller = new ReservationsController();
// $controller->showReservations(); // si tuvieras lógica previa

// Cargar directamente la vista
require_once ROOT_PATH . '/app/views/user/reservations.php';
