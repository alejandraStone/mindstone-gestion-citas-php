<?php 
require_once '../session/session_manager.php';//isAuthenticated() y getUser()

//muestro las clases disponibles y un formulario para que el usuario reserve su clase

if(!isAuthenticated()){
    header("Location: login.php");
    exit;
}else{
    $user = getUser();
    echo "<h2>Bienvenido/a, " . htmlspecialchars($user['name']) . "</h2>";//para proteger de inyección de código

?>
<!-- Aquí se mostrarán los días para los que se pueden reservar las clases -->
<h2>Available Classes:</h2>
<label>Class schedule (per day):</label><br>

    <div id="days-schedules" style="display: flex; gap: 10px;">
        <!-- Aquí JS meterá los días dinámicamente -->
    </div>

    <div id="class-results">
        <!-- Aquí aparecerán las clases disponibles para el día seleccionado -->
    </div>
  <!-- Llamamos a las funciones de JS (book_lessons)-->
  <script src="/mindStone/public/js/book_lessons.js"></script>
<style>
    .confirmation-message {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #4caf50;
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    font-size: 16px;
    z-index: 9999;
}
</style>
<?php
}

?>

