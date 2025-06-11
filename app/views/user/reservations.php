<?php
require_once __DIR__ . '/../../../app/config/config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Reservation</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
</head>
<!-- Layout dashboard header y aside -->
<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard_user.php'; ?>

<main class="mt-10 bg-white flex flex-col items-center rounded-xl border border-brand-200 box-border w-full overflow-hidden px-4 sm:px-6 py-10 lg:py-20">

<!-- Contenedor título + tarjeta en fila -->
<section class="flex flex-col lg:flex-row items-center justify-between w-full max-w-5xl mb-8 gap-6">

  <!-- Título ocupa todo el ancho en móvil, y auto en desktop -->
  <h1 class="text-2xl font-semibold text-brand-900 font-titulo whitespace-nowrap w-full lg:w-auto text-center lg:text-left">
    My Reservations
  </h1>

  <!-- Contenedor tarjetas de créditos -->
  <section id="credits-container" class="w-full lg:w-auto flex flex-col gap-4">
    <!-- JS inyecta tarjetas -->
  </section>
</section>

    <!-- Tabla ocupa ancho completo -->
    <div class="overflow-x-auto rounded-2xl shadow-xl border border-brand-200 bg-white w-full max-w-5xl">
        <table class="table-auto text-sm text-left text-brand-900 bg-white rounded-2xl w-full">
            <thead class="bg-gradient-to-r from-brand-400 via-brand-600 to-brand-800 text-white uppercase text-xs tracking-widest">
                <tr>
                    <th class="px-5 py-4">Class</th>
                    <th class="px-5 py-4">Coach</th>
                    <th class="px-5 py-4">Date</th>
                    <th class="px-5 py-4">Hour</th>
                    <th class="px-5 py-4">Reserved at</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4">Actions</th>
                </tr>
            </thead>
            <tbody id="reservations-table-body" class="divide-y divide-brand-100 bg-brand-50">
                <!-- JS injects rows here -->
            </tbody>
        </table>
    </div>
    <div id="pagination-controls" class="flex items-center justify-center gap-4 mt-6"></div>


</main>


</div><!-- cierre del div del Contenedor del aside y main -->
<script type="module" src="/mindStone/public/js/modules/show_user_reservations.js"></script>

</body><!-- cierre del body del Contenedor del aside y main -->

</html>