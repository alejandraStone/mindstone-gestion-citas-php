<?php
require_once __DIR__ . '/../../../config/config.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: /login.php');
    exit;
}
?>

<form method="POST" action="/mindStone/app/controllers/create_admin.php">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" required>
    <label for="lastName">Last name</label>
    <input type="text" name="lastName" id="lastName" required>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>
    <label for="phone">Phone</label>
    <input type="phone" name="phone" id="phone" required>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Crear Admin</button>
</form>