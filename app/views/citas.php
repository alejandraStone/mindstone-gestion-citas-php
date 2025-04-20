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
    
    <label for="date">date:</label>
    <input type="date" id="date" name="date">

    <label for="hour">hour: </label>
    <input type="time" id="hour" name="hour">
    
    <label for="tipo">Choose pilates type</label><br>
    <input type="radio" id="fullBody" name="pilates_type" value="fullBody">
    <label for="fullBody">MindStone Full Body</label><br>

    <input type="radio" id="reformer" name="pilates_type" value="reformer">
    <label for="reformer">MindStone Reformer</label><br>

    <input type="radio" id="mat" name="pilates_type" value="mat">
    <label for="mat">MindStone Mat</label><br>

    <label for="coach">Choose a coach:</label>
    <select name="coach" id="coach">
        <option value="">-- Loading coaches... --</option>
    </select>

    <script>
        document.addEventListener("DOMContentLoaded", function(){
            fetch("../models/getCoach.php")
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById("coach");
                select.innerHTML = '<option value= "">--Choose a coach--</option>';
                data.forEach(coach => {
                    let option = document.createElement("option");
                    option.value = coach.id;
                    option.textContent = coach.name;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error("Error loading coach:", error));
        });
    </script>
    

    <button type="submit">Book</button>
</form>
    

</body>
</html>
