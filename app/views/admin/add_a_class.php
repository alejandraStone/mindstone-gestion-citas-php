<?php
require_once realpath(path: __DIR__ . '/../../config/config.php');
require_once realpath(path: __DIR__ . '/../../models/speciality_model.php');
//llamo al método para que me muestre las especialidades de pilates que hay en l bbdd
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

<!-- Layout dashboard header y aside -->
<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard.php'; ?>

<main class="flex-1 mt-20 bg-[#f7f7fa] min-h-screen flex flex-col items-center py-12 px-2">
    <div class="w-full max-w-5xl">

        <h1 class="text-3xl font-bold mb-10 text-brand-900 font-titulo lg:text-4xl text-left">Add a Pilates Class</h1>

        <form id="add-class-form" class="space-y-12">
            <!-- Bloque de días en columnas tipo calendario -->
            <div>
                <label class="block mb-2 text-brand-800 font-semibold">Choose the schedule:</label>
                <div id="days-schedules" class="w-full grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                    <!-- JS rellena aquí los días, cada uno se verá en una columna -->
                </div>
            </div>
            <!-- Bloque de opciones principales en 3 columnas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                <!-- Tipo de pilates -->
                <div>
                    <label class="block mb-2 text-brand-800 font-semibold">Choose pilates type:</label>
                    <?php if (!empty($specialities)): ?>
                        <select id="pilates-type" name="pilates_type" class="w-full border border-brand-200 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-brand-500 transition">
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
                <!-- Capacidad -->
                <div>
                    <label for="capacity" class="block mb-2 text-brand-800 font-semibold">Capacity:</label>
                    <input type="number" name="capacity" id="capacity" required
                        class="w-full bg-white border border-brand-200 shadow-sm rounded-xl px-5 py-3 text-brand-900 focus:ring-2 focus:ring-brand-500 transition" />
                </div>
                <!-- Coach -->
                <div>
                    <label for="coach" class="block mb-2 text-brand-800 font-semibold">Select a coach:</label>
                    <select name="coach" id="coach"
                        class="w-full bg-white border border-brand-200 shadow-sm rounded-xl px-5 py-3 text-brand-900 focus:ring-2 focus:ring-brand-500 transition">
                        <option value="">-- Loading coaches... --</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" id="submit-button"
                    class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-8 rounded-xl shadow transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Save Class
                </button>
            </div>
            <div id="form-message" class="mt-4 text-center text-sm font-semibold font-normal"></div>
        </form>

    </div>
</main>
</div><!-- cierre del div del Contenedor del aside y main -->
</body>

</html>