<?php
require_once realpath(__DIR__ . '/../../config/config.php');
require_once ROOT_PATH . '/app/session/session_manager.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindStone</title>
    <link rel="stylesheet" href="/mindStone/public/css/output.css">
    <script src="/mindStone/public/js/app.js"></script>
</head>

<body class="font-normal">

    <header class="header w-full bg-brand-100 text-brand-950 flex justify-around items-center p-5">

        <!-- Logo -->
        <div id="logo">
            <img src="/mindStone/public/img/logo_mindStone_p.png" alt="logo" class="w-20 h-auto">
        </div>

        <!-- Botón hamburguesa (solo visible en móviles y tablet) -->
        <button class="lg:hidden" id="hamburger">
            <svg id="icon-open" xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon"
                class="w-6 h-6 transition-transform duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!-- Botón cerrar menú equis-->
            <svg id="icon-close" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon"
                class="w-6 h-6 hidden transition-transform duration-300 rotate-90">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Menú desplegable (solo visible cuando se activa el hamburguesa) -->
        <div id="mobileMenu" class="md:hidden hidden w-full flex flex-col items-center space-y-6 absolute top-[120px] left-0 right-0
         bg-brand-50 p-10 transition-all duration-300 ease-in-out transform -translate-y-5 opacity-0
         ">
            <a href="<?= BASE_URL ?>public/inicio.php">Home</a>
            <a href="#" class="menu-link">Services</a>
            <a href="#" class="menu-link">Contact</a>
            <a href="#" class="menu-link">About us</a>
            
            <?php if (isset($_SESSION['user'])): //si está logueada (user/admin) se muestra?>
            <a href="#" class="menu-link">My reservations</a>
           
            <?php if ($_SESSION['user']['role'] === 'admin'): //si admin se loguea?>
            <a href="/mindStone/app/views/admin/dashboard.php" class="menu-link">Dashboard</a>
            <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Menú para pantallas grandes -->
        <nav class="hidden md:flex space-x-6" id="menu">
            <a href="<?= BASE_URL ?>public/inicio.php" class="menu-link">Home</a>
            <a href="#" class="menu-link">Services</a>
            <a href="#" class="menu-link">Contact</a>
            <a href="#" class="menu-link">About us</a>
            
            <?php if (isset($_SESSION['user'])): //si está logueada (user/admin) se muestra?>
            <a href="#" class="menu-link">My reservations</a>

            <?php if ($_SESSION['user']['role'] === 'admin'): //si admin se loguea?>
                <a href="/mindStone/app/views/admin/dashboard.php" class="menu-link">Dashboard</a>
            <?php endif; ?>
            <?php endif; ?>
        </nav>

        <?php if (!isset($_SESSION['user'])): ?>
        <a href="<?= BASE_URL ?>app/views/auth/login.php" class="bg-brand-400 px-2 py-1 text-sm sm:text-base rounded-full">
        Log in
        </a>
        <?php else: ?>
        <a href="<?= BASE_URL ?>app/session/logout.php" class="bg-red-400 px-2 py-1 text-sm sm:px-6 sm:py-2 sm:text-base rounded-full">
        Log out
        </a>
        <?php endif; ?>

    </header>

</body>

</html>