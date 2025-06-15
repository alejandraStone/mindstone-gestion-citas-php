<?php
require_once __DIR__ . '/../../../app/config/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/mindStone/public/css/output.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <title>Classes</title>
</head>

<body class="font-normal pt-20 box-border overflow-x-hidden bg-brand-50">
    <?php require_once ROOT_PATH . '/app/views/layout/header.php'; ?>

    <!-- Hero Section -->
    <section id="contacto" class="relative text-brand-50 w-full h-[80vh] md:h-[80vh] lg:h-screen overflow-hidden flex items-center"
        style="background-image: url('/mindStone/public/img/bg-contacto.jpg'); background-size: cover; background-position: center;">
        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black bg-opacity-40 z-0"></div>
        <div class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 md:grid-cols-2 gap-8 z-10 items-center">
            <!-- TEXTO E ÍCONOS -->
            <div class="flex flex-col justify-center w-full overflow-hidden">
                <h2 class="titulo-grande text-white leading-tight mb-6" data-aos="fade-right">
                    Contact!<br>We will be happy to answer you.</h2>
            </div>
            <!-- FORMULARIO -->
            <div class="w-full flex justify-center items-center">
                <form class="w-full max-w-sm md:max-w-md lg:max-w-md mx-auto bg-transparent flex flex-col gap-6" id="cta-contact-form" novalidate data-aos="fade-left">

                    <!-- Nombre -->
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Your name"
                        class="w-full bg-transparent border-b border-white text-white placeholder-white focus:outline-none focus:border-white transition-all py-2" />
                    <span class="text-red-500 text-sm mt-1 hidden" id="name-error">Please enter a valid name.</span>

                    <!-- Email -->
                    <input
                        type="email"
                        id="email_form_contact"
                        name="email"
                        placeholder="your@email.com"
                        class="w-full bg-transparent border-b border-white text-white placeholder-white focus:outline-none focus:border-white transition-all py-2" />
                    <span class="text-red-500 text-sm mt-1 hidden" id="email-error">Please enter a valid email.</span>

                    <!-- Teléfono -->
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="Your phone"
                        class="w-full bg-transparent border-b border-white text-white placeholder-white focus:outline-none focus:border-white transition-all py-2" />
                    <span class="text-red-500 text-sm mt-1 hidden" id="phone-error">Please enter a valid phone number.</span>
                    <!-- Consulta/Mensaje -->
                    <textarea
                        id="message"
                        name="message"
                        placeholder="Write your query or message here"
                        rows="4"
                        class="w-full bg-transparent border-b border-white text-white placeholder-white focus:outline-none focus:border-white transition-all py-2"></textarea>
                    <span class="text-red-500 text-sm mt-1 hidden" id="message-error">Please enter your message.</span>

                    <!-- Botón cuadrado -->
                    <button
                        type="submit"
                        class="w-1/2 text-white text-lg px-4 py-2 border border-white hover:bg-white hover:text-brand-800 transition-all">
                        Send
                    </button>
                    <span class="text-green-400 text-base mt-2 hidden text-center" id="success-message">Thank you! We will contact you soon.</span>
                </form>
            </div>
        </div>
    </section>

    <!-- Detalle de la Ubicación-->
    <section class="w-full bg-brand-50 pt-10 pb-20">
        <!-- Título -->
        <h2 class="titulo-gradiente mb-10 text-center">
            <span class="titulo-punto mr-2">·</span>
            Find us at
            <span class="titulo-punto ml-2">·</span>
        </h2>

        <div class="container mx-auto flex flex-col items-stretch gap-10 px-4">
            <!-- Mapa -->
            <div class="w-full flex items-center justify-center">
                <iframe
                    class="w-full min-h-[400px] md:min-h-[500px] rounded-2xl shadow-md"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12638.420945442505!2d-0.4934415443172141!3d38.34599619773192!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6236d7e177be4f%3A0x9e0f66b5e709fd7e!2sAlicante!5e0!3m2!1ses!2ses!4v1716915747795!5m2!1ses!2ses"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <!-- Iconos-->
            <div class="w-full flex flex-col md:flex-row justify-center gap-4">
                <!-- Whatsapp -->
                <div class="w-full md:w-1/2 lg:w-1/4 h-32 rounded-2xl shadow-md bg-white border border-brand-300 hover:bg-verdeOlivaClaro hover:text-white transition-all duration-300 flex items-center gap-4 justify-center p-4" data-aos="zoom-in">
                    <div class="p-2 mb-2 rounded-full border border-brand-300">
                        <a href="https://wa.me/tu_numero" target="_blank" rel="noopener" aria-label="WhatsApp">
                            <svg class="w-6 h-6 fill-brand-400 stroke-brand-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                        </a>
                    </div>
                    <div class="flex flex-col justify-start">
                        <span class="text-sm leading-tight font-bold">WhatsApp</span>
                        <span class="text-sm leading-tight">666 987 654</span>
                    </div>
                </div>
                <!-- Email -->
                <div class="w-full md:w-1/2 lg:w-1/4 h-32 rounded-2xl shadow-md bg-white border border-brand-300 hover:bg-verdeOlivaClaro hover:text-white transition-all duration-300 flex items-center gap-4 justify-center p-4" data-aos="zoom-in">
                    <div class="p-2 mb-2 rounded-full border border-brand-300">
                        <a href="mailto:info@example.com" target="_blank" rel="noopener" aria-label="email">
                            <svg class="w-6 h-6 fill-brand-400 stroke-white xmlns=" http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </a>
                    </div>
                    <div class="flex flex-col justify-start">
                        <span class="text-sm leading-tight font-bold">Email</span>
                        <span class="text-sm leading-tight">info@example.com</span>
                    </div>
                </div>
                <!-- Instagram -->
                <div class="w-full md:w-1/2 lg:w-1/4 h-32 rounded-2xl shadow-md bg-white border border-brand-300 hover:bg-verdeOlivaClaro hover:text-white transition-all duration-300 flex items-center gap-4 justify-center p-4" data-aos="zoom-in">
                    <div class="p-2 mb-2 rounded-full border border-brand-300">
                        <a href="https://instagram.com/tu_usuario" target="_blank" rel="noopener" aria-label="Instagram">
                            <svg class="w-6 h-6 fill-brand-400 stroke-brand-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" class="w-8 h-8"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                            </svg>
                        </a>
                    </div>
                    <div class="flex flex-col justify-start">
                        <span class="text-sm leading-tight font-bold">Instagram</span>
                        <span class="text-sm leading-tight">mindstone</span>
                    </div>
                </div>
                <!-- Dirección -->
                <div class="w-full md:w-1/2 lg:w-1/4 h-32 rounded-2xl shadow-md bg-white border border-brand-300 hover:bg-verdeOlivaClaro hover:text-white transition-all duration-300 flex items-center gap-4 justify-center p-4" data-aos="zoom-in">
                    <!-- Icono con fondo, borde y estilos personalizados -->
                    <div class="p-2 rounded-full border border-brand-300">
                        <svg class="w-6 h-6 fill-brand-400 stroke-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-start">
                        <span class="text-sm leading-tight font-bold">Adress</span>
                        <span class="text-sm leading-tight">Street example,<br>Alicante, Spain</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require_once ROOT_PATH . '/app/views/layout/footer.php'; ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, // la animación se ejecuta una sola vez
            offset: 100, // empieza a animar 100px antes de entrar al viewport
            duration: 1000
        });
    </script>
    <script src="/mindStone/app/lib/jquery-3.7.1.js"></script>
    <script type="module" src="/mindStone/public/js/inicio.js"></script>
</body>

</html>