<?php
require_once __DIR__ . '/../../../app/config/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/mindStone/public/css/output.css">
    <!-- Lib JS slideshow Slick -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <title>Classes</title>
</head>

<body class="font-normal pt-20 box-border overflow-x-hidden bg-brand-50">
    <?php require_once ROOT_PATH . '/app/views/layout/header.php'; ?>

    <!-- Hero Section -->
    <section class="relative h-[80vh] md:h-[80vh] lg:h-screen w-full overflow-hidden flex items-center justify-center">
        <!-- Imagen de fondo -->
        <div class="absolute inset-0 z-0">
            <img
                src="/mindStone/public/img/hero-studio.jpg"
                alt="Pilates Class"
                class="w-full h-full object-cover lg:object-[center_bottom]" />
            <!-- Gradiente lateral oscuro-->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
        </div>
        </div>
        <!-- Contenedor del texto -->
        <div class="relative z-10 px-6 text-center">
            <h1
                id="hero-title"
                class="titulo-grande text-white"
                data-aos="fade-up">
                Welcome to MindStone Pilates Studio
            </h1>
        </div>
    </section>

<!-- Misión -->
<section class="relative w-full bg-brand-50 pb-10 z-20 overflow-hidden rounded-t-[80px] mt-[-80px]">
  <div class="container flex flex-col lg:flex-row justify-center items-center gap-10 md:gap-8 lg:gap-16 pt-20">
    
    <!-- Texto misión -->
    <div 
      class="flex flex-col justify-center text-center lg:text-left md:max-w-[50%] lg:max-w-[45%]" 
      data-aos="fade-right">
      <h2 class="titulo-gradiente mb-10">
        <span class="titulo-punto">·</span>
        Our Mission <span class="titulo-punto">·</span>
      </h2>
      <p class="tamaño-texto-general mb-5">
        At MindStone, our mission is to provide a welcoming and empowering space where individuals of all levels can experience the transformative benefits of Pilates.<br><br>
        Whether you're seeking improved flexibility, core stability, or a deeper connection with your body, MindStone is committed to helping you move with purpose and live with vitality.<br><br>
        Through small-group sessions, personalized instruction, and a community-focused environment, we aim to create a studio where you feel seen, safe, and inspired.
        At MindStone, Pilates is more than a workout. It's a way of life. A path to balance, strength, and inner clarity.
      </p>
      <span class="block font-titulo text-brand-900 text-lg mt-4">— Ale & Ale</span>
    </div>

    <!-- Imagen misión -->
    <div 
      class="flex justify-center md:max-w-[50%] lg:max-w-[55%]" 
      data-aos="fade-left">
      <img
        src="/mindStone/public/img/misión.jpg"
        alt="Our Mission"
        class="rounded-xl object-cover w-full max-w-xs md:max-w-[350px] lg:max-w-[420px] aspect-[4/5] shadow-lg" />
    </div>

  </div>
</section>

    <!-- SlideShow-->
    <section class="container px-4 lg:px-10 py-16 mx-auto max-w-[1280px] relative overflow-hidden">
        <!-- Título -->
        <div class="px-4 md:px-6 lg:px-6 mb-6"
            data-aos="fade-in">
            <h2 class="titulo-gradiente text-center">
                <span class="titulo-punto">·</span>
                Explore Our Studio <span class="titulo-punto">·</span>
            </h2>
        </div>

        <div class="lazy">
            <div><img data-lazy="/mindStone/public/img/slide1.jpg" class="h-[400px] w-full object-cover rounded-2xl shadow-lg" alt="Imagen 1"></div>
            <div><img data-lazy="/mindStone/public/img/slide2.jpg" class="h-[400px] w-full object-cover rounded-2xl shadow-lg" alt="Imagen 2"></div>
            <div><img data-lazy="/mindStone/public/img/slide3.jpg" class="h-[400px] w-full object-cover rounded-2xl shadow-lg" alt="Imagen 3"></div>
            <div><img data-lazy="/mindStone/public/img/slide4.jpg" class="h-[400px] w-full object-cover rounded-2xl shadow-lg" alt="Imagen 4"></div>
            <div><img data-lazy="/mindStone/public/img/slide5.jpg" class="h-[400px] w-full object-cover rounded-2xl shadow-lg" alt="Imagen 5"></div>
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
    <script src="/mindStone/public/js/studio.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</body>

</html>