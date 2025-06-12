<?php
require_once __DIR__ . '/../../../app/config/config.php';
require_once ROOT_PATH . '/app/session/session_manager.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: ' . BASE_URL . 'public/inicio.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
    <title>Dashboard-User</title>
</head>

<!-- Layout dashboard header y aside -->
<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard_user.php'; ?>
<main class="flex-1 lg:flex-col mt-10" data-user-id="<?= $_SESSION['user']['id'] ?>">
    <!--Card del user-->
    <div class="flex flex-row p-8 gap-4 justify-between bg-brand-100 border border-brand-200 rounded-xl animate-fade-in">
        <div class="flex-1 flex flex-col justify-center pl-8">
            <h2 class="text-4xl md:text-5xl font-titulo text-brand-900 mb-2">Hi,
                <?= htmlspecialchars($_SESSION['user']['name']) ?></h2>
            <p class="text-brand-700 font-normal">Choose a class and book</p>
        </div>
        <div class="flex-1 flex items-center justify-center">
            <img src="/mindStone/public/img/logo_mindStone_p.png" class="w-20 h-20" alt="logo-mindStone" />
        </div>
    </div>
    <!-- Horario/calendario -->
    <section class="relative bg-brand-50 py-5 mb-10">
            <div class="container">
                <!-- Título -->
                <div class="p-4 md:p-6 lg:p-6"
                    data-aos="fade-in">
                    <h2 class="titulo-gradiente text-center mb-2">
                        <span class="titulo-punto">·</span>
                        Class Timetable
                        <span class="titulo-punto">·</span>
                    </h2>
                    <!-- Semana actual que muestra las clases -->
                    <div
                        id="monthDisplay"
                class="mx-auto mb-6 w-max rounded-full text-brand-800 hover:bg-brand-800 hover:text-white font-semibold px-6 py-2 text-xs md:text-base tracking-tight shadow ring-1 ring-brand-200 select-none">
                        <!-- Aquí JS pondrá la semana de clases -->
                    </div>

                </div>

                <!-- Calendario -->
                <div id="calendar" class="mt-2 calendar-wrapper empty relative max-w-7xl mx-auto rounded-xl bg-white shadow-lg overflow-x-auto">
                    <!-- Tabla se inyecta por JavaScript -->
                </div>
            </div>
    </section>
</main>
</div><!-- cierre del div del Contenedor del aside y main -->

<script src="/mindStone/app/lib/jquery-3.7.1.js"></script>
<script src="/mindStone/public/js/calendario.js"></script>

</body><!-- cierre del body del Contenedor del aside y main -->

</html>