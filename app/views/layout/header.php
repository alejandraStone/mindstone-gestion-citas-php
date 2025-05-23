<?php
require_once realpath(__DIR__ . '/../../config/config.php');
require_once ROOT_PATH . '/app/session/session_manager.php';
?>

<header class="fixed top-0 left-0 right-0 z-50 w-full bg-brand-100 text-brand-950">
  <div class="container mx-auto py-2 flex justify-between items-center relative">

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
                class="w-6 h-6 transition-transform duration-300">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>

            <svg id="icon-close"
            class="w-6 h-6 transition-transform duration-300 hidden"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>

        </button>

        <!-- Menú desplegable -->
        <div id="mobileMenu"
            class="hidden lg:hidden flex flex-col items-center space-y-10 absolute top-full left-0 right-0 bg-brand-100 p-8 z-[100] transition-opacity duration-300 opacity-0">
            <a href="<?= BASE_URL ?>public/inicio.php" class="menu-link-desplegable">Home</a>
            <a href="<?= BASE_URL ?>app/views/services.php" class="menu-link-desplegable">Services</a>
            <a href="<?= BASE_URL ?>app/views/about.php" class="menu-link-desplegable">About us</a>
            <a href="<?= BASE_URL ?>app/views/contact.php" class="menu-link-desplegable">Contact</a>

            <?php if (isset($_SESSION['user'])): ?>
                <a href="<?= BASE_URL ?>app/views/user/reservations.php" class="menu-link-desplegable">My reservations</a>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="/mindStone/app/views/admin/dashboard.php" class="menu-link-desplegable">Dashboard</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Menú pantallas grandes -->
        <nav class="hidden md:hidden lg:flex gap-10" id="menu">
            <a href="<?= BASE_URL ?>public/inicio.php" class="menu-link">Home</a>
            <a href="<?= BASE_URL ?>app/views/services.php" class="menu-link">Services</a>
            <a href="<?= BASE_URL ?>app/views/about.php" class="menu-link">About us</a>
            <a href="<?= BASE_URL ?>app/views/contact.php" class="menu-link">Contact</a>

            <?php if (isset($_SESSION['user'])): ?>
                <a href="<?= BASE_URL ?>app/views/user/reservations.php" class="menu-link">My reservations</a>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="/mindStone/app/views/admin/dashboard.php" class="menu-link">Dashboard</a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>

        <!-- Login / Logout -->
        <?php if (!isset($_SESSION['user'])): ?>
            <button id="loginBtn" type="button" class="btn-peticion">Log in</button>
        <?php else: ?>
            <a href="<?= BASE_URL ?>app/session/logout.php" class="btn-peticion">Log out</a>
        <?php endif; ?>

    </div>
</header>

<!-- Popup Login Modal oculto por defecto-->
<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6 relative">
        <!-- Botón para cerrar -->
        <button id="closeLoginModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-center">Sign in to your account</h2>
        <form class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <div class="flex flex-col gap-2">
                <button type="submit"
                    class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-lg">
                    Login
                </button>
                <!-- Enlace para contraseña olvidada -->
                <button
                    type="button"
                    id="forgotPasswordBtn"
                    class="text-brand-600 hover:underline text-sm ml-2">
                    Forgot password?
                </button>
            </div>
        </form>
        <!-- Enlace de registro -->
        <div class="mt-10 text-sm text-center flex flex-col gap-2">
            Are you new to MindStone?
            <a href="<?= BASE_URL ?>app/views/auth/signup.php" class="text-brand-600 font-semibold hover:underline">
                Sign up here!
            </a>
        </div>
    </div>
</div>

<!-- Modal para contraseña olvidada -->
<div id="forgotPasswordModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6 relative">
        <button id="closeForgotPasswordModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-center">Forgot your password?</h2>
        <form id="forgotPasswordForm" class="space-y-4">
            <div>
                <label for="forgot_email" class="block text-sm font-medium text-gray-700 mb-1">Enter your email address</label>
                <input type="email" name="forgot_email" id="forgot_email" required
                    class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <button type="submit"
                class="w-full bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-lg">
                Send password to my email
            </button>
        </form>
        <div id="forgotPasswordMsg" class="mt-4 text-center text-sm"></div>
    </div>
</div>