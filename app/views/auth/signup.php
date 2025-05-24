<?php 
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/mindStone/public/js/signup.js"></script>
    <title>Sign up</title>
    <link rel="stylesheet" href="/mindStone/public/css/output.css">
</head>
<body class="bg-brand-50 min-h-screen flex flex-col items-center justify-center font-normal">
    <div class="w-full max-w-md mx-auto flex flex-col items-center px-4 py-8">
        <!-- Logo principal -->
        <img src="/mindStone/public/img/logo_mindStone_p.png" alt="logo" class="w-20 h-auto mb-4 mt-2 sm:mb-6">

        <!-- Título y subtítulo -->
        <h1 class="text-3xl font-semibold text-brand-800 mb-2 text-center">Sign up</h1>
        <h2 class="text-lg text-brand-700 mb-6 text-center">Welcome to MindStone Pilates</h2>

        <!-- Formulario de registro -->
        <form method="post" id="formSignup" class="w-full flex flex-col gap-4 bg-white p-6 rounded-xl shadow-md">
            <!-- Campo de nombre -->
            <div class="flex flex-col">
                <label for="name" class="text-sm font-medium text-brand-900 mb-1">First name</label>
                <input type="text" name="name" id="name" required autocomplete="given-name"
                    class="px-3 py-2 rounded-lg border border-brand-200 bg-brand-50 focus:outline-none focus:ring-2 focus:ring-brand-400 text-brand-900 placeholder-brand-300"
                    placeholder="Enter your first name">
            </div>
            <!-- Campo de apellido -->
            <div class="flex flex-col">
                <label for="lastName" class="text-sm font-medium text-brand-900 mb-1">Last name</label>
                <input type="text" name="lastName" id="lastName" required autocomplete="family-name"
                    class="px-3 py-2 rounded-lg border border-brand-200 bg-brand-50 focus:outline-none focus:ring-2 focus:ring-brand-400 text-brand-900 placeholder-brand-300"
                    placeholder="Enter your last name">
            </div>
            <!-- Campo de email -->
            <div class="flex flex-col">
                <label for="email" class="text-sm font-medium text-brand-900 mb-1">Email</label>
                <input type="email" name="email" id="email" required autocomplete="email"
                    class="px-3 py-2 rounded-lg border border-brand-200 bg-brand-50 focus:outline-none focus:ring-2 focus:ring-brand-400 text-brand-900 placeholder-brand-300"
                    placeholder="name@example.com">
            </div>
            <!-- Campo de teléfono -->
            <div class="flex flex-col">
                <label for="phone" class="text-sm font-medium text-brand-900 mb-1 flex items-center gap-1">
                    Phone
                    <span title="Enter your phone number" class="cursor-pointer text-brand-400">
            
                    </span>
                </label>
                <input type="tel" name="phone" id="phone" required autocomplete="tel"
                    class="px-3 py-2 rounded-lg border border-brand-200 bg-brand-50 focus:outline-none focus:ring-2 focus:ring-brand-400 text-brand-900 placeholder-brand-300"
                    placeholder="+34 666 848 759">
            </div>
            <!-- Campo de contraseña -->
            <div class="flex flex-col">
                <label for="password" class="text-sm font-medium text-brand-900 mb-1 flex items-center gap-1">
                    Password
                    <span title="Password must be at least 6 characters" class="cursor-pointer text-brand-400">
                    </span>
                </label>
                <input type="password" name="password" id="password" required minlength="6"
                    class="px-3 py-2 rounded-lg border border-brand-200 bg-brand-50 focus:outline-none focus:ring-2 focus:ring-brand-400 text-brand-900 placeholder-brand-300"
                    placeholder="At least 6 characters">
            </div>
            <!-- Botón de registro -->
            <button type="submit"
                class="bg-brand-400 text-white font-semibold rounded-lg py-3 mt-2 hover:bg-brand-500 transition-colors">
                Sign up
            </button>
        </form>

        <!-- Mensaje de feedback para el usuario -->
        <div id="signupMsg" class="mt-6 text-center text-sm"></div>
    </div>
</body>
</html>