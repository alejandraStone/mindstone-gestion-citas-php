<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Pilates Class</title>
    <link rel="stylesheet" href="/mindStone/public/styles/add_class.css">

</head>
<body>
    <h1>Add a Pilates Class</h1>

    <form method="POST" action="/mindStone/app/controllers/add_a_class_controller.php">

        <label>Choose pilates type</label><br>
        <input type="radio" name="pilates_type" value="fullBody"> MindStone Full Body<br>
        <input type="radio" name="pilates_type" value="reformer"> MindStone Reformer<br>
        <input type="radio" name="pilates_type" value="mat"> MindStone Mat<br><br>

        <label>Class schedule (per day):</label><br>

        <div id="days-schedules">
            <!-- Aquí se generarán los días dinámicamente con JS -->
        </div>

        <br>
        <label for="capacity">Capacity:</label>
        <input type="number" name="capacity" id="capacity" required><br><br>

         <!-- Aquí se cargarán los coachs con Ajax -->
        <label for="coach">Select a coach:</label>
        <select name="coach" id="coach">
            <option value="">-- Loading coaches... --</option>
        </select>

        <br><br>
        <button type="submit">Save class</button>
    </form>

        <!-- Llamamos a las funciones de JS (coaches y días)-->
        <script src="/mindStone/public/js/add_class.js"></script>

</body>
</html>
