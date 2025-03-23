<?php 
require_once '../session/sessionManager.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book</title>
</head>
<body>
<?php 

if(!isAuthenticated()){
    header("Location: login.php");
    exit;
}else{
    $user = getUser();
    echo "Bienvendida, " . $user['name'];
}
?>    


<h1>Reserva una nueva clase</h1>
<form action="ReservarCitasController.php" method="POST">
    
    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" name="fecha">

    <label for="hora">Hora: </label>
    <input type="time" id="hora" name="hora">
    
    <label for="tipo">Tipo de pilates</label><br>
    <input type="radio" id="fullBody" name="tipo_pilates" value="fullBody">
    <label for="fullBody">MindStone Full Body</label><br>

    <input type="radio" id="reformer" name="tipo_pilates" value="reformer">
    <label for="reformer">MindStone Reformer</label><br>

    <input type="radio" id="mat" name="tipo_pilates" value="mat">
    <label for="mat">MindStone Mat</label><br>

    <label for="monitor">Selecciona un monitor:</label>
    <select name="monitor" id="monitor">
        <option value="">-- Cargando monitores... --</option>
    </select>

    <script>
        document.addEventListener("DOMContentLoaded", function(){
            fetch("../models/getMonitores.php")
            .then(Response => Response.json())
            .then(data => {
                let select = document.getElementById("monitor");
                select.innerHTML = '<option value= "">--Selecciona un monitor--</option>';
                data.forEach(monitor => {
                    let option = document.createElement("option");
                    option.value = monitor.id;
                    option.textContent = monitor.nombre;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error("Error al cargar monitores:", error));
        });
    </script>
    

    <button type="submit">Reservar</button>
</form>
    

</body>
</html>
