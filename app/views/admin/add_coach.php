<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Add a new coach</h1>
    <form action="/mindStone/app/controllers/add_coach_controller.php" method="POST">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="phone">Phone</label>
        <input type="phone" name="phone" id="phone">

        <label for="star_time">Star time</label>
        <input type="time" name="start_time" id="star_time">

        <label for="finish_time">Finish time</label>
        <input type="time" name="finish_time" id="finish_time">

        <fieldset>
            <legend>Speciality</legend>
            <label for="fullBody">Full Body</label>
            <input type="checkbox" name="speciality[]" value="Full Body" id="fullBody"><br>
            
            <label for="reformer">Reformer</label>
            <input type="checkbox" name="speciality[]" value="Reformer" id="reformer"><br>
            
            <label for="mat">Mat</label>
            <input type="checkbox" name="speciality[]" value="Mat" id="mat">
        </fieldset>
        
        <button type="submit">Add coach</button>

    </form>

<!-- Mostrar mensaje de éxito o error -->
<?php if (isset($_GET['success'])): ?>
    <p style="color: green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
<?php elseif (isset($_GET['error'])): ?>
    <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
<?php endif; ?>

</body>
</html>