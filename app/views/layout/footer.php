<?php
require_once realpath(__DIR__ . '/../../config/config.php');
require_once ROOT_PATH . '/app/session/session_manager.php';
?>

<footer class="pt-16 pb-7 bg-brand-700">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col min-[830px]:flex-row items-center justify-between gap-6 pb-10 border-b-2 border-gray-200">
            <!-- Logo -->
            <div id="logo_footer">
                <img src="/mindStone/public/img/logo_footer.png" alt="logo" class="w-[130px] h-auto">
            </div>
            <!-- Links -->
            <ul class="flex flex-col sm:flex-row items-center gap-5 sm:gap-12 text-brand-50">
                <li><a href="<?= BASE_URL ?>public/inicio.php" class="hover:text-brand-400 font-normal transition-all duration-300 focus-within:outline-0">Home</a></li>
                <li><a href="<?= BASE_URL ?>app/views/pages/classes.php" class="hover:text-brand-400 font-normal transition-all duration-300 focus-within:outline-0">Classes</a></li>
                <li><a href="<?= BASE_URL ?>app/views/pages/studio.php" class="hover:text-brand-400 font-normal transition-all duration-300 focus-within:outline-0">Studio</a></li>
                <li><a href="<?= BASE_URL ?>app/views/pages/contact.php" class="hover:text-brand-400 font-normal transition-all duration-300 focus-within:outline-0">Contact</a></li>
            </ul>
        </div>
        <!-- Iconos RRSS y Copyright-->
        <div class="pt-7 flex flex-col min-[520px]:flex-row items-center justify-between gap-6">
            <span class="text-sm font-normal text-white">©MindStone</a> 2025, All rights reserved.</span>
            <div class="flex items-center gap-4">
                <!-- WhatsApp -->
                <a href="https://wa.me/tu_numero" target="_blank" rel="noopener" aria-label="WhatsApp"
                    class="border border-gray-300 p-2 rounded-full aspect-square text-white transition-all duration-500 hover:text-brand-400 hover:border-brand-400 focus-within:outline-0 focus-within:text-brand-400 focus-within:border-brand-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" class="w-8 h-8">
                        <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
                    </svg>
                </a>
                <!-- Instagram -->
                <a href="https://instagram.com/tu_usuario" target="_blank" rel="noopener" aria-label="Instagram"
                    class="border border-gray-300 p-2 rounded-full aspect-square text-white transition-all duration-500 hover:text-brand-400 hover:border-brand-400 focus-within:outline-0 focus-within:text-brand-400 focus-within:border-brand-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" class="w-8 h-8"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                    </svg>
                </a>
                <!-- TikTok -->
                <a href="https://tiktok.com/@tu_usuario" target="_blank" rel="noopener" aria-label="TikTok"
                    class="border border-gray-300 p-2 rounded-full aspect-square text-white transition-all duration-500 hover:text-brand-400 hover:border-brand-400 focus-within:outline-0 focus-within:text-brand-400 focus-within:border-brand-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" class="w-8 h-8"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" />
                    </svg>
                </a>

            </div>
        </div>
    </div>
</footer>