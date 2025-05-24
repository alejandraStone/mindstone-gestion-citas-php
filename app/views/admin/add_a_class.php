<?php

/**
 * Bloque de vista para la sección de administración que permite agregar una nueva clase.
 * Este archivo contiene la estructura y elementos necesarios para que un administrador
 * pueda introducir los datos requeridos para crear una clase en el sistema.
 *
 * Ubicación: /app/views/admin/add_a_class.php
 */
require_once realpath(__DIR__ . '/../../config/config.php');
require_once realpath(__DIR__ . '/../../models/speciality_model.php');
$specialities = Speciality::getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="<?= BASE_URL ?>/public/js/modules/add_class.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
    <title>Add Pilates Class</title>
</head>

<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard.php'; ?>

<!-- Bloque que contiene todo el tema para agregar una clase -->
<main class="flex-1 mt-10 bg-white min-h-screen flex flex-col items-center p-6 rounded-xl border border-brand-200">
    <h1 class="text-2xl font-semibold mb-10 text-brand-900 font-titulo text-left">Add a Pilates Class</h1>
    <form id="add-class-form" class="space-y-10 w-full max-w-5xl mt-6">
        <!--Bloque principal de tipo, capacidad y coach -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div>
                <label class="block font-semibold text-brand-800 mb-2">Choose pilates type:</label>
                <?php if (!empty($specialities)): ?>
                    <select id="pilates-type" name="pilates_type"
                        class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition">
                        <option value="">-- Select a type --</option>
                        <?php foreach ($specialities as $speciality): ?>
                            <option value="<?= $speciality['id'] ?>">
                                <?= htmlspecialchars($speciality['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <p class="text-sm text-red-400">No specialities available.</p>
                <?php endif; ?>
            </div>
            <div>
                <label for="capacity" class="block font-semibold text-brand-800 mb-2">Capacity:</label>
                <input type="number" name="capacity" id="capacity" placeholder="15" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="coach" class="block font-semibold text-brand-800 mb-2">Select a coach:</label>
                <select name="coach" id="coach"
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition">
                    <option value="">-- Loading coaches --</option>
                </select>
            </div>
        </div>
        <!--Bloque de días tipo calendario -->
        <div id="weekly-agenda" class="mt-8">
            <h3 class="text-base font-semibold text-brand-900 mb-3">Select days and hours for the class:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-2" id="agenda-grid">
                <!-- Agenda injected by JS -->
            </div>
        </div>
        <!--Bloque para el botón de guardar clase y mostrar clases -->
        <div class="flex justify-start gap-4">
            <button type="submit" id="submit-button"
                class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed shadow-none">
                Save Class
            </button>
            <button type="button" id="toggle-class-list"
                class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed shadow-none">
                Show Classes
            </button>
        </div>
        <!--Bloque para el mensaje de error/correcto -->
        <div id="form-message" class="mt-4 text-center text-sm font-semibold font-normal"></div>
    </form>

    <!--Contenedor principal para mostrar las clases -->
    <div id="class-list-section" class="w-full max-w-7xl mt-10 mx-auto hidden">
        <h1 class="text-2xl font-semibold mb-10 text-brand-900 font-titulo text-center">Class List</h1>
        <!-- Bloque que contiene el filtrado de una clase -->
        <div id="class-filters"
            class="w-full flex flex-wrap gap-4 mb-8 items-center bg-brand-50 rounded-xl px-6 py-4 shadow">
            <!-- Filtro día de la semana -->
            <div>
                <span class="font-semibold text-brand-900 mr-3">Day:</span>
                <span id="filter-day-list" class="inline-flex gap-2"></span>
            </div>
            <!-- Filtro tipo de clase -->
            <div>
                <span class="font-semibold text-brand-900 mr-3">Type:</span>
                <span id="filter-type-list" class="grid grid-cols-2 gap-2 sm:flex sm:gap-2"></span>
            </div>

        </div>

        <!-- Bloque que contiene el listado tipo calendario de las clases -->
        <div id="calendar-class-list" class="w-full mt-8 mb-8"></div>
    </div>
</main>
<!-- Popup para editar la clase -->
<div id="edit-class-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg relative">
        <button id="close-edit-modal"
            class="absolute top-2 right-2 text-xl text-brand-700 hover:text-red-600">&times;</button>
        <h2 class="text-xl font-semibold mb-4">Edit Class</h2>
        <form id="edit-class-form" class="space-y-4">
            <input type="hidden" id="edit-class-id">
            <div>
                <label class="block mb-1 text-brand-700">Type</label>
                <select id="edit-pilates-type" class="w-full border rounded px-2 py-1"></select>
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Coach</label>
                <select id="edit-coach" class="w-full border rounded px-2 py-1"></select>
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Capacity</label>
                <input type="number" id="edit-capacity" class="w-full border rounded px-2 py-1" min="1">
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Day</label>
                <select id="edit-day" class="w-full border rounded px-2 py-1">
                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                    <option>Thursday</option>
                    <option>Friday</option>
                    <option>Saturday</option>
                    <option>Sunday</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Hour</label>
                <input type="time" id="edit-hour" class="w-full border rounded px-2 py-1">
            </div>
            <div id="edit-form-message" class="text-center text-red-600 font-semibold"></div>
            <button type="submit" class="bg-brand-700 text-white px-4 py-2 rounded hover:bg-brand-800 w-full">Save
                Changes</button>
        </form>
    </div>
</div>
</div><!-- cierre del div del Contenedor del aside y main -->
</body>

</html>