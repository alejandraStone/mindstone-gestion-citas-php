<?php
/**
 * Bloque de vista para la sección de administración que permite agregar un nuevo coach.
 * Este archivo contiene la estructura y elementos necesarios para que un administrador
 * pueda introducir los datos requeridos para crear un coach en el sistema.
 *
 * Ubicación: /app/views/admin/add_coach.php
 */
require_once __DIR__ . '/../../../app/config/config.php';
require_once ROOT_PATH . '/app/models/speciality_model.php';

$specialities = Speciality::getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
  <title>Add Coach</title>
</head>

<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard.php'; ?>

<main class="mt-10 bg-white min-h-screen flex-1 flex flex-col items-center p-6 rounded-xl border border-brand-200">

  <!-- Header -->
  <div class="w-full flex justify-between items-center mb-6 mt-10">
    <h1 class="text-2xl font-semibold text-brand-900 font-titulo">Coach List</h1>
    <button id="toggle-add-coach"
      class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition shadow-none">
      Add Coach
    </button>
  </div>

  <!-- Tabla para mostrar todos coaches -->
  <div id="coach-list-wrapper" class="w-full overflow-x-auto border border-brand-100 rounded-xl mt-10">
    <div id="coaches-list"></div>
  </div>

  <!-- Formulario agregar coach -->
  <form id="add-coach-form" class="space-y-10 w-full max-w-7xl mt-10 hidden" novalidate>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div>
        <label for="name" class="block font-semibold text-brand-800 mb-2">Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter your first name"
          class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 transition" />
      </div>
      <div>
        <label for="lastName" class="block font-semibold text-brand-800 mb-2">Last Name:</label>
        <input type="text" name="lastName" id="lastName" placeholder="Enter your last name"
          class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 transition" />
      </div>
      <div>
        <label for="email" class="block font-semibold text-brand-800 mb-2">Email:</label>
        <input type="email" name="email" id="email" placeholder="name@example.com"
          class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 transition" />
      </div>
      <div>
        <label for="phone" class="block font-semibold text-brand-800 mb-2">Phone:</label>
        <input type="tel" name="phone" id="phone" pattern="^\+\d{6,15}$" placeholder="+34123456789" maxlength="16"
          class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 transition" />
      </div>
    </div>

    <?php
    $specialityColors = [
      "Full Body" => "bg-lime-100 border-lime-200",
      "Mat"       => "bg-emerald-100 border-emerald-200",
      "Reformer"  => "bg-violet-100 border-violet-300"
    ];
    ?>

    <!-- Especialidades -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <?php foreach ($specialities as $speciality): ?>
        <?php $colorClasses = $specialityColors[$speciality['name']] ?? "bg-brand-50 border-brand-200"; ?>
        <label class="flex items-center gap-3 p-3 rounded-xl border <?= $colorClasses ?> hover:shadow transition cursor-pointer group">
          <input type="checkbox" name="speciality[]" value="<?= $speciality['id'] ?>" class="hidden peer" />
          <span class="flex items-center justify-center w-5 h-5 rounded-lg border-2 border-brand-400 peer-checked:bg-brand-500 peer-checked:border-brand-500 bg-white transition">
            <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 20 20">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l4 4 6-7" />
            </svg>
          </span>
          <span class="text-brand-900 font-medium"><?= htmlspecialchars($speciality['name']) ?></span>
        </label>
      <?php endforeach; ?>
    </div>

    <!-- Botón submit -->
    <div class="flex justify-start">
      <button type="submit" id="submit-button"
        class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed shadow-none">
        Add Coach
      </button>
    </div>
    <div id="form-message" class="mt-4 text-center text-sm font-semibold"></div>
  </form>
</main>

<!-- Modal editar coach -->
<div id="edit-coach-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg relative">
    <button id="close-edit-modal" class="absolute top-2 right-2 text-xl text-brand-700 hover:text-red-600">&times;</button>
    <h2 class="text-xl font-semibold mb-4">Edit Coach</h2>
    <form id="edit-coach-form" class="space-y-4">
      <input type="hidden" name="id" id="coach-id" />
      <div>
        <label class="block mb-1 text-brand-700">Name</label>
        <input type="text" id="edit-name" name="name" class="w-full border rounded px-2 py-1" />
      </div>
      <div>
        <label class="block mb-1 text-brand-700">Last Name</label>
        <input type="text" id="edit-lastName" name="lastName" class="w-full border rounded px-2 py-1" />
      </div>
      <div>
        <label class="block mb-1 text-brand-700">Email</label>
        <input type="email" id="edit-email" name="email" class="w-full border rounded px-2 py-1" />
      </div>
      <div>
        <label class="block mb-1 text-brand-700">Phone</label>
        <input type="tel" id="edit-phone" name="phone" class="w-full border rounded px-2 py-1" />
      </div>
      <div id="edit-specialities-list" class="flex flex-wrap gap-2">
        <!-- Aquí se insertarán dinámicamente las especialidades con JS -->
      </div>
      <div id="edit-form-message" class="text-center text-red-600 font-semibold"></div>
      <button type="submit" class="bg-brand-700 text-white px-4 py-2 rounded hover:bg-brand-800 w-full">Save Changes</button>
    </form>
  </div>
</div>

<script type="module" src="<?= BASE_URL ?>/public/js/modules/add_coach.js"></script>
</body>
</html>
