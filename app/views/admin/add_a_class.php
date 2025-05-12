<?php 
require_once realpath(__DIR__ . '/../../config/config.php'); // primera vez para definir ROOT_PATH
require_once ROOT_PATH . '/app/config/config.php';

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
    <title>Add Pilates Class</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-2xl">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Add a Pilates Class</h1>

        <form id="add-class-form" class="bg-brand-50 p-6 rounded-2xl shadow-lg max-w-xl mx-auto font-normal">

            <h2 class="text-2xl font-titulo text-brand-800 mb-6 text-center">Add a Pilates Class</h2>

            <label class="block mb-2 text-brand-800 font-semibold">Choose pilates type:</label>
            <div class="mb-4 space-y-1">
                <label class="block"><input type="radio" name="pilates_type" value="fullBody" class="mr-2">MindStone Full Body</label>
                <label class="block"><input type="radio" name="pilates_type" value="reformer" class="mr-2">MindStone Reformer</label>
                <label class="block"><input type="radio" name="pilates_type" value="mat" class="mr-2">MindStone Mat</label>
            </div>

            <label class="block mb-2 text-brand-800 font-semibold">Class schedule (per day):</label>
            <div id="days-schedules" class="space-y-4 mb-4">
                <!-- Se llenan los días desde JS -->
            </div>

            <label for="capacity" class="block mb-2 text-brand-800 font-semibold">Capacity:</label>
            <input type="number" name="capacity" id="capacity" required class="w-full p-2 border border-brand-200 rounded mb-4">

            <label for="coach" class="block mb-2 text-brand-800 font-semibold">Select a coach:</label>
            <select name="coach" id="coach" class="w-full p-2 border border-brand-200 rounded mb-6">
                <option value="">-- Loading coaches... --</option>
            </select>

            <button type="submit" id="submit-button" class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-2 px-4 rounded w-full transition disabled:opacity-50 disabled:cursor-not-allowed">
                Save Class
            </button>

            <div id="form-message" class="mt-4 text-center text-sm font-semibold font-normal"></div>
        </form>


        <script src="<?= BASE_URL ?>/public/js/modules/add_class.js"></script>
</body>

</html>