<?php
require_once realpath(__DIR__ . '/../../config/config.php');
require_once realpath(__DIR__ . '/../../session/session_manager.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
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
    <title>Dashboard</title>
</head>

        <!-- Layout dashboard header y aside -->
        <?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard.php';?>
        <main class="flex-1 lg:flex-col mt-10">
            <!--Card del admin-->
            <div class="flex flex-row p-8 gap-4 mb-4 justify-between bg-brand-100 border border-brand-200 rounded-xl animate-fade-in">
                <div class="flex-1 flex flex-col justify-center pl-8">
                    <h2 class="text-4xl md:text-5xl font-titulo text-brand-900 mb-2">Hi, Admin</h2>
                    <p class="text-brand-700 font-normal">Ready to start your day with some MindStone?</p>
                </div>
                <div class="flex-1 flex items-center justify-center">
                    <img src="/mindStone/public/img/logo_mindStone_p.png" class="w-72 h-auto" alt="logo-mindStone" />
                </div>
            </div>
            <!--Cards info-->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!--Card books-->
                <div class="cards-dashboard">
                    <!-- Heroicon: CalendarDays -->
                    <div class="icono-dashboard">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-9 h-9 text-white">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="titulo-card-dashboard">Bookings</span>
                        <span class="text-4xl font-bold text-brand-700 leading-none mb-1">20</span>
                        <span class="flex items-center text-green-500 font-medium text-sm">+8% this month</span>
                    </div>
                </div>
                <!--Card most popular class-->
                <div class="cards-dashboard">
                    <!-- Heroicon: Fire -->
                    <div class="icono-dashboard">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-9 h-9 text-white">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="titulo-card-dashboard">Most popular class</span>
                        <span class="text-4xl font-bold text-brand-700 leading-none mb-1">20</span>
                        <span class="flex items-center text-green-500 font-medium text-sm">+8% this month</span>
                    </div>
                </div>
                <!--CardClasses with low occupancy-->
                <div class="cards-dashboard">
                    <!-- Heroicon: ExclamationTriangle -->
                    <div class="icono-dashboard">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-9 h-9 text-white">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="titulo-card-dashboard">Classes with low occupancy</span>
                        <span class="text-4xl font-bold text-brand-700 leading-none mb-1">20</span>
                        <span class="flex items-center text-green-500 font-medium text-sm">+8% this month</span>
                    </div>
                </div>
                <!--Card peek hours-->
                <div class="cards-dashboard">
                    <!-- Heroicon: Clock -->
                    <div class="icono-dashboard">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-9 h-9 text-white">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6v6l3 3" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="titulo-card-dashboard">Peak hours</span>
                        <span class="text-4xl font-bold text-brand-700 leading-none mb-1">20</span>
                        <span class="flex items-center text-green-500 font-medium text-sm">+8% this month</span>
                    </div>
                </div>
                <!--Card users-->
                <div class="cards-dashboard">
                    <!-- Heroicon: Users -->
                    <div class="icono-dashboard">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-9 h-9 text-white">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="titulo-card-dashboard">Users</span>
                        <span class="text-4xl font-bold text-brand-700 leading-none mb-1">20</span>
                        <span class="flex items-center text-green-500 font-medium text-sm">+8% this month</span>
                    </div>
                </div>
                <!--Card views-->
                <div class="cards-dashboard">
                    <!-- Heroicon: ChartBar -->
                    <div class="icono-dashboard">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-9 h-9 text-white">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="titulo-card-dashboard">Views to the website</span>
                        <span class="text-4xl font-bold text-brand-700 leading-none mb-1">20</span>
                        <span class="flex items-center text-green-500 font-medium text-sm">+8% this month</span>
                    </div>
                </div>
            </div>
        </main>
</div><!-- cierre del div del Contenedor del aside y main -->
</body><!-- cierre del body del Contenedor del aside y main -->
</html>