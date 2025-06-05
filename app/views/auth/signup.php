<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="/mindStone/public/css/output.css">
</head>

<body class="min-h-screen flex items-center justify-center font-normal">
    <div class="w-full max-w-4xl bg-brand-100 shadow-md sm:rounded-lg flex flex-col sm:flex-row justify-center p-6 sm:p-10">
        <!-- Columna izquierda: logo y mensaje -->
        <div class="sm:w-1/2 flex flex-col items-center justify-center text-center p-4">
            <img src="/mindStone/public/img/logo_mindStone_p.png" alt="logo" class="w-20 h-auto mb-4">
            <h1 class="text-3xl font-semibold text-brand-800 mb-2">Sign up</h1>
            <h2 class="text-lg text-brand-700">Welcome to MindStone Pilates</h2>
        </div>

        <!-- Columna derecha: formulario -->
        <div class="sm:w-1/2 mt-6 sm:mt-0">
            <form method="post" id="formSignup" class="w-full flex flex-col gap-4 bg-white p-6 rounded-xl">
                <!-- Nombre -->
                <div class="flex flex-col">
                    <label for="name" class="text-sm font-medium text-brand-900 mb-1">First name</label>
                    <input type="text" name="name" id="name"
                         class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-400 text-brand-900 placeholder-brand-300"
                        placeholder="Enter your first name">
                </div>
                <!-- Apellido -->
                <div class="flex flex-col">
                    <label for="lastName" class="text-sm font-medium text-brand-900 mb-1">Last name</label>
                    <input type="text" name="lastName" id="lastName"
                         class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-400 text-brand-900 placeholder-brand-300"
                        placeholder="Enter your last name">
                </div>
                <!-- Email -->
                <div class="flex flex-col">
                    <label for="email" class="text-sm font-medium text-brand-900 mb-1">Email</label>
                    <input type="email" name="email" id="email"
                         class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-400 text-brand-900 placeholder-brand-300"
                        placeholder="name@example.com">
                </div>
                <!-- Teléfono -->
                <div class="flex flex-col">
                    <label for="phone" class="text-sm font-medium text-brand-900 mb-1">Phone</label>
                    <input type="tel" name="phone" id="phone" pattern="^\+\d{6,15}$" placeholder="+34123456789" maxlength="16"
                         class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-400 text-brand-900 placeholder-brand-300">
                </div>
                <!-- Contraseña -->
                <div class="flex flex-col">
                    <label for="password" class="text-sm font-medium text-brand-900 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                         class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-400 text-brand-900 placeholder-brand-300"
                        placeholder="At least 8 characters, 1 uppercase, 1 number, 1 special char">
                </div>
                <!-- Botón de registro -->
                <button type="submit"
                    class="bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-lg py-3 mt-2 transition-colors">
                    Sign up
                </button>
            </form>

            <!-- Mensaje de feedback -->
            <div id="signupMsg" class="mt-6 text-center text-sm text-brand-600"></div>
        </div>
    </div>

    <script src="/mindStone/public/js/signup.js"></script>
</body>

</html>