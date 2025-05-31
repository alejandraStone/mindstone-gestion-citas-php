<?php
require_once realpath(__DIR__ . '/../../config/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/mindStone/public/js/dashboard.js"></script>
    <link rel="stylesheet" href="/mindStone/public/css/output.css">
    <title>Aside dashboard</title>
</head>

<body class="bg-brand-50 min-h-screen font-normal text-brand-900 overflow-x-hidden">
    <header class="w-full h-16 bg-white text-brand-800 shadow-lg font-titulo">
        <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between h-16">
            <button class="mobile-menu-button p-2 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor"
                    class="w-7 h-7 transition-transform duration-300 text-brand-900">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            <div class="text-2xl font-titulo tracking-wide text-brand-900">
                <span>User Panel</span>
            </div>
        </div>
    </header>
    <!-- Contenedor del aside y main -->
    <div class="flex flex-col lg:flex-row lg:items-start w-full gap-4 px-2 lg:px-8">
        <!-- Sidebar -->
        <aside class="sidebar fixed flex flex-col top-0 left-0 w-full lg:static lg:w-[240px] h-full mt-20 lg:mt-10 p-4 gap-4 lg:translate-x-0 transform -translate-x-full transition-transform duration-300 bg-brand-100 z-45 rounded-xl border border-brand-200">
            <!-- Card aside 1 -->
            <div class="bg-white rounded-xl shadow-md p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <!-- Sidebar links Dashboard -->
                <a href="<?= BASE_URL ?>public/pages/reservations.php" class="flex items-center text-brand-700 hover:text-brand-900 py-3 ml-2 transition-all duration-300 hover:translate-x-1 font-normal">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6 mr-2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                    </svg>
                    TimeTable
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-4 ml-auto">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
                <!--Home-->
                <a href="<?= BASE_URL ?>public/inicio.php" class="flex items-center text-brand-700 hover:text-brand-900 py-3 ml-2 transition-all duration-300 hover:translate-x-1 font-normal">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6 mr-2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    WebSite
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-4 ml-auto">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
                <!--Log out -->
                <a href="<?= BASE_URL ?>app/session/logout.php" class="flex items-center text-brand-700 hover:text-brand-900 py-3 ml-2 transition-all duration-300 hover:translate-x-1 font-normal">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6 mr-2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
                    </svg>

                    Log out
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-4 ml-auto">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
        </aside>
</html>