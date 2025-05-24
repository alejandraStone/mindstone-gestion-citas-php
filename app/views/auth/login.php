<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/mindStone/app/views/layout/header.php';
require_once realpath(__DIR__ . '/../../config/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Welcome back!</h2>
    <form action="<?= BASE_URL ?>app/controllers/log_in_controller.php" method="POST" id="formLogin">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <button name="login">Log in</button>
    </form>
</body>
</html>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/mindStone/app/views/layout/footer.php';?>
