<?php

/**
 * Bloque de vista para la sección de administración que permite agregar un nuevo coach.
 * Este archivo contiene la estructura y elementos necesarios para que un administrador
 * pueda introducir los datos requeridos para crear un coach en el sistema.
 *
 * Ubicación: /app/views/admin/add_coach.php
 */
require_once realpath(__DIR__ . '/../../config/config.php');
require_once realpath(__DIR__ . '/../../models/speciality_model.php');
$specialities = Speciality::getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="<?= BASE_URL ?>/public/js/modules/add_coach.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
    <title>Add Coach</title>
</head>

<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard.php'; ?>

<main class="flex-1 mt-10 bg-white min-h-screen flex flex-col items-center p-6 rounded-xl border border-brand-200">
    <h1 class="text-2xl font-semibold mb-10 text-brand-900 font-titulo text-left">Add a New Coach</h1>
    <form id="add-coach-form" class="space-y-10 w-full max-w-5xl mt-6">
        <!-- Bloque principal de datos personales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-start">
            <div>
                <label for="name" class="block font-semibold text-brand-800 mb-2">Name:</label>
                <input type="text" name="name" id="name" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="name" class="block font-semibold text-brand-800 mb-2">Last Name:</label>
                <input type="text" name="lastName" id="lastName" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="email" class="block font-semibold text-brand-800 mb-2">Email:</label>
                <input type="email" name="email" id="email" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="phone" class="block font-semibold text-brand-800 mb-2">Phone:</label>
                <input type="tel" name="phone" id="phone" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
        </div>

        <?php
        // Asocio los mismos colores a los nombres de especialidades
        // para que se mantenga la misma lógica de colores en el formulario
        $specialityColors = [
            "Full Body" => "bg-lime-100 border-lime-200",
            "Mat"       => "bg-emerald-100 border-emerald-200",
            "Reformer"  => "bg-violet-100 border-violet-300"
        ];
        ?>
        <!-- Bloque de especialidades -->
        <div>
            <label class="block font-semibold text-brand-800 mb-2">Speciality:</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php if (!empty($specialities)): ?>
                    <?php foreach ($specialities as $speciality): ?>
                        <?php
                        $colorClasses = $specialityColors[$speciality['name']] ?? "bg-brand-50 border-brand-200";
                        ?>
                        <label class="flex items-center gap-3 p-3 rounded-xl border <?= $colorClasses ?> hover:shadow transition cursor-pointer group select-none">
                            <input
                                type="checkbox"
                                name="speciality[]"
                                value="<?= $speciality['id'] ?>"
                                class="hidden peer"
                                id="speciality-<?= $speciality['id'] ?>">
                            <span class="flex items-center justify-center w-5 h-5 rounded-lg border-2 border-brand-400 transition-all duration-150
                        peer-checked:bg-brand-500 peer-checked:border-brand-500
                        peer-focus:ring-2 peer-focus:ring-brand-300
                        bg-white">
                                <!-- Check SVG visible solo si está checked -->
                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-100" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 20 20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l4 4 6-7" />
                                </svg>
                            </span>
                            <span class="text-brand-900 font-medium"><?= htmlspecialchars($speciality['name']) ?></span>
                        </label>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-sm text-red-400">No specialities available.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Botones y mensaje -->
        <div class="flex justify-start gap-4">
            <button type="submit" id="submit-button"
                class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed shadow-none">
                Add Coach
            </button>
            <!-- Botón para mostrar coaches -->
            <button type="button" id="toggle-coach-list"
                class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed shadow-none">
                Show Coaches
            </button>
        </div>
        <div id="form-message" class="mt-4 text-center text-sm font-semibold font-normal"></div>
    </form>
    <!-- Contenedor para mostrar los coaches: OCULTO por defecto -->
    <div id="coach-list-section" class="w-full max-w-5xl mt-10 mx-auto hidden">
        <h1 class="text-2xl font-semibold mb-10 text-brand-900 font-titulo text-center">Coach List</h1>
        <div id="coaches-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"></div>
    </div>
</main>
<!-- Popup para editar coach (opcional, según tu lógica JS) -->
<div id="edit-coach-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg relative">
        <button id="close-edit-modal"
            class="absolute top-2 right-2 text-xl text-brand-700 hover:text-red-600">&times;</button>
        <h2 class="text-xl font-semibold mb-4">Edit Coach</h2>
        <form id="edit-coach-form" class="space-y-4">
            <input type="hidden" id="edit-coach-id">
            <div>
                <label class="block mb-1 text-brand-700">Name</label>
                <input type="text" id="edit-name" class="w-full border rounded px-2 py-1" />
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Email</label>
                <input type="email" id="edit-email" class="w-full border rounded px-2 py-1" />
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Phone</label>
                <input type="tel" id="edit-phone" class="w-full border rounded px-2 py-1" />
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block mb-1 text-brand-700">Start Time</label>
                    <input type="time" id="edit-start_time" class="w-full border rounded px-2 py-1" />
                </div>
                <div>
                    <label class="block mb-1 text-brand-700">Finish Time</label>
                    <input type="time" id="edit-finish_time" class="w-full border rounded px-2 py-1" />
                </div>
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Specialities</label>
                <div id="edit-specialities-list" class="flex flex-wrap gap-2"></div>
            </div>
            <div id="edit-form-message" class="text-center text-red-600 font-semibold"></div>
            <button type="submit" class="bg-brand-700 text-white px-4 py-2 rounded hover:bg-brand-800 w-full">Save Changes</button>
        </form>
    </div>
</div>
</div><!-- cierre del div del Contenedor del aside y main -->
</body>

</html>