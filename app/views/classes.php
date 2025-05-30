<?php
require_once __DIR__ . '/../../app/config/config.php';
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
    <section class="relative h-[80vh] md:h-[80vh] lg:h-screen w-full overflow-hidden">
        <!-- Imagen de fondo con gradiente oscuro a la derecha -->
        <div class="absolute inset-0 z-0">
            <img
                src="/mindStone/public/img/hero-classes.jpg"
                alt="Pilates Class"
                class="w-full h-full object-cover lg:object-[center_top]" />
            <!-- Gradiente lateral oscuro desde la derecha -->
            <div class="absolute inset-0 bg-gradient-to-l from-black/60 via-black/30 to-transparent"></div>
        </div>

        <!-- Contenedor del texto -->
        <div class="relative z-10 flex flex-col items-center justify-center lg:justify-center lg:items-end h-full text-center lg:text-right px-4 sm:px-6">
            <div class="max-w-[90%] lg:max-w-xl">
                <h1
                    id="hero-title"
                    class="titulo-grande text-white mb-6 opacity-0 translate-y-12 transition-all duration-1000"
                    data-aos="fade-left">
                    Find the class that suits you best
                </h1>
            </div>
            <a href="#siguiente-seccion" id="scroll-trigger">
                <svg class="w-6 animate-bounce text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 5.25 7.5 7.5 7.5-7.5m-15 6 7.5 7.5 7.5-7.5" />
                </svg>
            </a>
        </div>
    </section>
    <!-- Sección servicios -->
    <section id="siguiente-seccion" class="grid grid-cols-1 md:grid-cols-2">

        <!-- REFORMER -->
        <!-- Imagen en md a la izquierda, en mobile después del texto -->
        <div class="bg-brand-100 order-2 md:order-1">
            <img src="/mindStone/public/img/reformer2.jpg" alt="reformer" class="w-full h-full object-cover" />
        </div>
        <!-- Texto primero en mobile, segundo en md -->
        <div class="bg-white flex items-center justify-center p-8 order-1 md:order-2">
            <div class="text-center md:text-left" data-aos="fade-up">
                <h2 class="font-titulo text-2xl md:text-3xl mb-4">Reformer</h2>
                <p class="text-sm md:text-base text-oliveShade max-w-md mx-auto md:mx-0">
                    Elevate your core strength and posture with our Reformer sessions. Ideal for improving alignment, flexibility, and toning with precision-controlled movements.
                </p>
            </div>
        </div>
        <!-- MAT -->
        <!-- Texto primero en todos los tamaños -->
        <div class="bg-brand-50 flex items-center justify-center p-8 order-3" data-aos="fade-up">
            <div class="text-center md:text-left">
                <h2 class="font-titulo text-2xl md:text-3xl mb-4">Mat</h2>
                <p class="text-sm md:text-base text-oliveShade max-w-md mx-auto md:mx-0">
                    Build deep strength using only your body weight. Our Mat classes focus on breath, stability, and control — no machines, just pure pilates on the mat.
                </p>
            </div>
        </div>
        <!-- Imagen después en todos los tamaños -->
        <div class="bg-brand-50 order-4">
            <img src="/mindStone/public/img/mat2.png" alt="mat" class="w-full h-full object-cover" />
        </div>
        <!-- FULL BODY -->
        <!-- Imagen primero en md, después en mobile -->
        <div class="bg-brand-300 order-6 md:order-5">
            <img src="/mindStone/public/img/full_body.jpg" alt="full body" class="w-full h-full object-cover" />
        </div>
        <!-- Texto primero en mobile, después en md -->
        <div class="bg-white flex items-center justify-center p-8 order-5 md:order-6">
            <div class="text-center md:text-left data-aos=" fade-up">
                <h2 class="font-titulo text-2xl md:text-3xl mb-4">Full Body</h2>
                <p class="text-sm md:text-base text-oliveShade max-w-md mx-auto md:mx-0">
                    Challenge your entire body in one dynamic session. From core to cardio, this class blends Pilates principles with functional training for total body power.
                </p>
            </div>
        </div>
    </section>

    <!-- Horario -->
    <section class="relative bg-brand-50 py-10 mb-10">
        <div class="container">
            <!-- Título -->
            <div class="p-4 md:p-6 lg:p-6"
                data-aos="fade-in">
                <h2 class="titulo-gradiente text-center mb-10">
                    <span class="titulo-punto">·</span>
                    Class Timetable
                    <span class="titulo-punto">·</span>
                </h2>
            </div>
            <!-- Calendario -->
            <div id="calendar" class="calendar-wrapper empty relative max-w-7xl mx-auto rounded-xl bg-white shadow-lg overflow-x-auto">
                <!-- Tabla se inyecta por JavaScript -->
            </div>
        </div>
    </section>

    <!-- Sección de Bonos 1-->
    <section class="w-full bg-brand-50 pb-20">
        <div class="container flex flex-col items-center justify-center">

            <!-- Título de la sección -->
            <h2 class="titulo-gradiente mb-10">
                <span class="titulo-punto mr-2">·</span>
                Find the Tariff that Best Suits your Needs<span class="titulo-punto ml-2">·</span>
            </h2>
            <!-- Contenedor de los bonos tipo grid, todos alineados verticalmente -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-7 mt-6 w-full max-w-4xl mx-auto">
                <!-- Unlimited Classes Card -->
                <div class="flex flex-col items-center bg-brad-50 p-8 shadow-lg max-w-sm lg:max-w-md border border-black" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="flex flex-col items-center w-full">
                        <h3 class="tamaño-subtitulo text-xl md:text-[24px] lg:text-[30px] text-center mb-1 tracking-normal">Unlimited Classes</h3>
                        <span class="text-brand-900 mb-4 text-base font-titulo">Per month</span>
                    </div>
                    <div class="flex items-end justify-center my-3 h-[88px]">
                        <span class="text-brand-900 text-[4rem] font-titulo leading-none">250</span>
                        <span class="text-brand-900 text-2xl mr-2 font-titulo">€</span>

                    </div>
                    <p class="text-base md:text-[18px] lg:text-[20px] text-brand-900 text-center mb-6 flex-1">
                        Attend every day of the week with no limitations.
                    </p>
                    <a href="<?= BASE_URL ?>app/views/user/buy_plan.php" class=" btn-cards">Join now</a>
                </div>
                <!-- 10 Classes Card -->
                <div class="flex flex-col items-center bg-brad-50 p-8 shadow-lg max-w-sm lg:max-w-md border border-black" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="flex flex-col items-center w-full">
                        <h3 class="tamaño-subtitulo text-xl md:text-[24px] lg:text-[30px] text-center mb-1 tracking-normal">10 Classes</h3>
                        <span class="text-brand-800 mb-4 text-base font-titulo">Every 4 weeks</span>
                    </div>
                    <div class="flex items-end justify-center my-3 h-[88px]">
                        <span class="text-brand-900 text-[4rem] font-titulo leading-none">200</span>
                        <span class="text-brand-900 text-2xl mr-2 font-titulo">€</span>

                    </div>
                    <p class="tamaño-texto-general text-brand-900 text-center mb-6 flex-1">
                        10 classes per month at any level.
                    </p>
                    <a href="<?= BASE_URL ?>app/views/user/buy_plan.php" class=" btn-cards">Join now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Info de las clases -->
    <section class="flex flex-col md:flex-row items-stretch justify-stretch w-full bg-brand-50">
        <!-- Info1 -->
        <div data-aos="fade-up" class="bg-verdeOlivaClaro flex flex-col items-center justify-center text-center w-full flex-1 px-6 py-20">
            <p class="text-lg italic text-black font-titulo">Suitable for Beginners<br>and Advanced Students</p>
        </div>

        <!-- Info2 -->
        <div data-aos="fade-up" data-aos-delay="100" class="bg-verdeOlivaMasClaro flex flex-col items-center justify-center text-center w-full flex-1 px-6 py-20">
            <p class="text-lg italic text-black font-titulo">50 Minutes<br>Class Session</p>
        </div>

        <!-- Info3 -->
        <div data-aos="fade-up" data-aos-delay="200" class="bg-verdeOliva flex flex-col items-center justify-center text-center w-full flex-1 px-6 py-20">
            <p class="text-lg italic text-black font-titulo">10+ Years of<br>Experience</p>
        </div>
    </section>

    <!-- Sección de Bonos 2-->
    <section class="w-full bg-brand-50 pt-20 pb-10 md:pt-20 md:pb-20 lg:pt-20 lg:pb-20">
        <div class="container flex flex-col items-center justify-center">
            <!-- Contenedor de los bonos tipo grid, todos alineados verticalmente -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-7 mt-6 w-full max-w-4xl mx-auto">
                <!-- 4 Classes Card -->
                <div class="flex flex-col items-center bg-brad-50 p-8 shadow-lg max-w-sm lg:max-w-md border border-black" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="flex flex-col items-center w-full">
                        <h3 class="tamaño-subtitulo text-brand-900 text-xl md:text-[24px] lg:text-[30px] text-center mb-1 tracking-normal">4 Classes</h3>
                        <span class="text-brand-900 mb-4 text-base font-titulo">Every 4 weeks</span>
                    </div>
                    <div class="flex items-end justify-center my-3 h-[88px]">
                        <span class="text-brand-900 text-[4rem] font-titulo leading-none">100</span>
                        <span class="text-brand-900 text-2xl mr-2 font-titulo">€</span>

                    </div>
                    <p class="tamaño-texto-general text-brand-900 text-center mb-6 flex-1">
                        4 classes per month at any level.
                    </p>
                    <a href="<?= BASE_URL ?>app/views/user/buy_plan.php" class=" btn-cards">Join now</a>
                </div>
                <!-- 1 Class Card -->
                <div class="flex flex-col items-center bg-brad-50 p-8 shadow-lg max-w-sm lg:max-w-md border border-black" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="flex flex-col items-center w-full">
                        <h3 class="tamaño-subtitulo text-brand-900 text-xl md:text-[24px] lg:text-[30px] text-center mb-1 tracking-normal">1 Class</h3>
                        <span class="text-brand-900 mb-4 text-base font-titulo">Individual</span>
                    </div>
                    <div class="flex items-end justify-center my-3 h-[88px]">
                        <span class="text-brand-900 text-[4rem] font-titulo leading-none">35</span>
                        <span class="text-brand-900 text-2xl mr-2 font-titulo">€</span>

                    </div>
                    <p class="tamaño-texto-general text-brand-900 text-center mb-6 flex-1">
                        1 individual class.
                    </p>
                    <a href="<?= BASE_URL ?>app/views/user/buy_plan.php" class=" btn-cards">Join now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ-->
    <section class="w-full bg-brand-50 pt-10 pb-10 md:pt-10 md:pb-20 lg:pt-10 lg:pb-20 mx-auto">
        <!-- Título de la sección -->
        <h2 class="titulo-gradiente mb-10 text-center">
            <span class="titulo-punto mr-2">·</span>
            Frequently Asked Questions
            <span class="titulo-punto ml-2">·</span>
        </h2>

        <div class="container flex flex-col md:flex-row items-stretch gap-4">
            <!-- Imagen -->
            <div class="w-full md:w-1/2 flex items-center justify-center">
                <img src="/mindStone/public/img/full_body.jpg" alt="Full Body Pilates" class="object-cover w-full h-full">
            </div>
            <!-- Preguntas FAQ -->
            <div class="w-full md:w-1/2 p-8 mx-auto bg-verdeOlivaClaro flex flex-col justify-between">
                <div class="space-y-6">

                    <!-- Pregunta -->
                    <div class="faq-item border-b pb-4">
                        <div class="faq-question flex items-center justify-between cursor-pointer text-md">
                            <p class="text-lg italic text-black font-titulo">Do I need to bring any equipment to the class?</p>
                            <svg class="faq-arrow w-6 h-6 text-gray-600 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div class="faq-answer mt-3 text-neutral-600 hidden">
                            Yes, you should come in comfortable sportswear and bring non-slip socks. If you don't have them, you can buy them at the studio reception.
                        </div>
                    </div>

                    <!-- Pregunta -->
                    <div class="faq-item border-b pb-4">
                        <div class="faq-question flex items-center justify-between cursor-pointer text-md">
                            <p class="text-lg italic text-black font-titulo">Do you have showers?</p>
                            <svg class="faq-arrow w-6 h-6 text-gray-600 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div class="faq-answer mt-3 text-neutral-600 hidden">
                            Yes, our studio has men's and women's changing rooms. You can shower at the end of the class.
                        </div>
                    </div>

                    <!-- Pregunta -->
                    <div class="faq-item border-b pb-4">
                        <div class="faq-question flex items-center justify-between cursor-pointer text-md">
                            <p class="text-lg italic text-black font-titulo">Can I rent a towel?</p>
                            <svg class="faq-arrow w-6 h-6 text-gray-600 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div class="faq-answer mt-3 text-neutral-600 hidden">
                            Yes, you can rent a towel for 2€.
                        </div>
                    </div>

                    <!-- Pregunta -->
                    <div class="faq-item border-b pb-4">
                        <div class="faq-question flex items-center justify-between cursor-pointer text-md">
                            <p class="text-lg italic text-black font-titulo">Is it possible to come if I have never done pilates?</p>
                            <svg class="faq-arrow w-6 h-6 text-gray-600 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div class="faq-answer mt-3 text-neutral-600 hidden">
                            Yes, we have a special class for people who have never done pilates. We also have two levels of difficulty: beginner and advanced.
                        </div>
                    </div>

                    <!-- Pregunta -->
                    <div class="faq-item border-b pb-4">
                        <div class="faq-question flex items-center justify-between cursor-pointer text-md">
                            <p class="text-lg italic text-black font-titulo">Class cancellation policy</p>
                            <svg class="faq-arrow w-6 h-6 text-gray-600 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div class="faq-answer mt-3 text-neutral-600 hidden">
                            Any Classes cancelled prior to the 9 hour cancellation window will be returned as a credit to your Membership or Class Pack.<br><br>
                            To cancel a booked Class, you must do so through your profile on the MindStone Pilates website.<br><br>
                            For Members with Memberships or Class Packs, cancelling a Class less than 9 hours before its start will result in the loss of the Class credit.<br>No show, or absence from a class without cancellation will result in the loss of the Class credit also.
                        </div>
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
    <script src="/mindStone/public/js/calendario.js"></script>
    <script src="/mindStone/public/js/classes.js"></script>
</body>

</html>