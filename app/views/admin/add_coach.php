<?php 
require_once realpath(__DIR__ . '/../../config/config.php');
require_once ROOT_PATH . '/app/config/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
    <title>Add a Coach</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-2xl">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Add a New Coach</h1>
        
        <form id="add-coach-form" class="bg-brand-50 p-6 rounded-2xl shadow-lg max-w-xl mx-auto font-normal">
            <label for="name" class="block mb-2 text-brand-800 font-semibold">Name:</label>
            <input type="text" name="name" id="name" required class="w-full p-2 border border-brand-200 rounded mb-4">
            
            <label for="email" class="block mb-2 text-brand-800 font-semibold">Email:</label>
            <input type="email" name="email" id="email" required class="w-full p-2 border border-brand-200 rounded mb-4">
            
            <label for="phone" class="block mb-2 text-brand-800 font-semibold">Phone:</label>
            <input type="tel" name="phone" id="phone" required class="w-full p-2 border border-brand-200 rounded mb-4">
            
            <label for="start_time" class="block mb-2 text-brand-800 font-semibold">Start Time:</label>
            <input type="time" name="start_time" id="start_time" required class="w-full p-2 border border-brand-200 rounded mb-4">
            
            <label for="finish_time" class="block mb-2 text-brand-800 font-semibold">Finish Time:</label>
            <input type="time" name="finish_time" id="finish_time" required class="w-full p-2 border border-brand-200 rounded mb-4">
            
            <fieldset class="mb-6">
                <legend class="text-brand-800 font-semibold">Specialty:</legend>
                <label for="fullBody" class="block"><input type="checkbox" name="speciality[]" value="Full Body" id="fullBody"> Full Body</label>
                <label for="reformer" class="block"><input type="checkbox" name="speciality[]" value="Reformer" id="reformer"> Reformer</label>
                <label for="mat" class="block"><input type="checkbox" name="speciality[]" value="Mat" id="mat"> Mat</label>
            </fieldset>
            
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-2 px-4 rounded w-full transition disabled:opacity-50 disabled:cursor-not-allowed">
                Add Coach
            </button>

            <!-- Mensaje de éxito o error -->
            <div id="form-message" class="mt-4 text-center text-sm font-semibold font-normal"></div>
        </form>
    </div>

    <!-- Script para enviar el formulario con AJAX -->
    <script src="<?= BASE_URL ?>/public/js/modules/add_coach.js"></script>
</body>
</html>
