<?php
require_once __DIR__ . '/../app/config/config.php';
require_once ROOT_PATH . '/app/views/layout/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="/mindStone/public/js/calendario.js"></script>
  <link rel="stylesheet" href="/mindStone/public/css/output.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <!-- Lib JS slideshow -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <!-- CND Iconos de rrss -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- AOS libreria para animaciones con JS -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
  <title>Home</title>
</head>

<body class="font-normal pt-20 overflow-x-hidden">
<?php
require_once ROOT_PATH . '/app/views/layout/header.php';
?>

<!-- Hero Section -->
<section class="relative h-[80vh] md:h-[80vh] lg:h-screen w-full overflow-x-hidden">
  <div class="absolute inset-0 z-0">
    <img src="img/hero.jpg" alt="Pilates Class" class="w-full h-full object-cover brightness-75" />
  </div>
  <div class="relative z-10 flex items-center justify-center h-full text-center px-4 sm:px-6">
    <div class="max-w-[90%]">
      <h1 id="hero-title" class="titulo-grande text-white mb-6 opacity-0 translate-y-12 transition-all duration-1000">
        Transform Your Body <br class="hidden sm:block"> Elevate Your Mind
      </h1>
      <a id="hero-btn" href="#booking" class="opacity-0 translate-y-12 transition-all duration-700 inline-block px-6 py-2 border border-white text-white font-titulo sm:text-lg tracking-wide hover:bg-white hover:text-brand-800">
        BOOK CLASS
      </a>
    </div>
  </div>
</section>

<!-- Misión -->
<section class="relative w-full bg-brand-50 py-10 px-4 -mt-10 md:-mt-16 lg:-mt-24 z-20 mission-arc">
  <div class="container flex flex-col md:flex-row items-center gap-10 md:gap-8 lg:gap-16 mt-16">
    <div class="w-full md:w-1/2 flex justify-center md:justify-start">
      <div id="mission-text" class="w-full max-w-md text-center md:text-left opacity-0 -translate-x-10 transition-all duration-1000">
        <h2 class="titulo-gradiente">
          <span class="titulo-punto">·</span>
          Our Mission <span class="titulo-punto">·</span>
        </h2>
        <p class="tamaño-texto-general mb-5">
          At MindStone, our mission is to provide a welcoming and empowering space where individuals of all levels can experience the transformative benefits of Pilates...<br><br>
          Whether you're seeking improved flexibility, core stability, or a deeper connection with your body, MindStone is committed to helping you move with purpose and live with vitality.
        </p>
        <span class="block font-titulo text-brand-900 text-lg mt-4">— Ale & Ale</span>
      </div>
    </div>
    <div class="w-full md:w-1/2 flex justify-center">
      <img id="mission-img" src="img/misión.jpg" alt="Our Mission" class="rounded-xl object-cover opacity-0 translate-x-10 transition-all duration-1000 w-full max-w-xs md:max-w-[350px] lg:max-w-[420px] aspect-[4/5] shadow-lg">
    </div>
  </div>
</section>

<!-- Servicios -->
<section class="w-full bg-brand-50 py-20 px-4">
  <div class="container flex flex-col items-center justify-center">
    <h2 class="titulo-gradiente lg:text-center">
      <span class="titulo-punto">·</span>
      Our Classes <span class="titulo-punto">·</span>
    </h2>
    <div class="w-full max-w-7xl mx-auto mt-10">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        <!-- Servicio 1 -->
        <div class="flex flex-col items-center text-center bg-white p-6 rounded-xl shadow-md transition-transform duration-300 hover:-translate-y-2 hover:shadow-lg" data-aos="fade-up" data-aos-delay="100">
          <div class="overflow-hidden w-48 h-64 mb-4 rounded-t-[100px]">
            <img src="img/full_body.jpg" alt="full body" class="object-cover w-full h-full transition-transform duration-500 hover:scale-110" />
          </div>
          <h3 class="tamaño-subtitulo">Full Body Pilates Class</h3>
          <p class="tamaño-texto-general text-sm">Strength, balance and energy in every move</p>
          <a href="#booking" class="btn-cards">Booking</a>
        </div>
        <!-- Servicio 2 -->
        <div class="flex flex-col items-center text-center bg-white p-6 rounded-xl shadow-md transition-transform duration-300 hover:-translate-y-2 hover:shadow-lg" data-aos="fade-up" data-aos-delay="200">
          <div class="overflow-hidden w-48 h-64 mb-4 rounded-t-[100px]">
            <img src="img/mat.jpg" alt="Mat class" class="object-cover w-full h-full transition-transform duration-500 hover:scale-110" />
          </div>
          <h3 class="tamaño-subtitulo">Mat Pilates Class</h3>
          <p class="tamaño-texto-general text-sm">Control your body, master your mind</p>
          <a href="#booking" class="btn-cards">Booking</a>
        </div>
        <!-- Servicio 3 -->
        <div class="flex flex-col items-center text-center bg-white p-6 rounded-xl shadow-md transition-transform duration-300 hover:-translate-y-2 hover:shadow-lg" data-aos="fade-up" data-aos-delay="300">
          <div class="overflow-hidden w-48 h-64 mb-4 rounded-t-[100px]">
            <img src="img/reformer.jpg" alt="Reformer class" class="object-cover w-full h-full transition-transform duration-500 hover:scale-110" />
          </div>
          <h3 class="tamaño-subtitulo">Reformer Pilates Class</h3>
          <p class="tamaño-texto-general text-sm">Precision, resistance, transformation</p>
          <a href="#booking" class="btn-cards">Booking</a>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- SlideShow-->
<section class="bg-brand-50 pt-10 pb-20 px-4">
  <div class="max-w-7xl mx-auto flex flex-col items-center justify-center">
    <h2 class="titulo-gradiente text-center">
      <span class="titulo-punto">·</span>
      Our Pilates Center
      <span class="titulo-punto">·</span>
    </h2>
    
    <div class="w-full px-4 sm:px-8 md:px-16 lg:px-0 mt-6">
      <div class="swiper gallery-swiper rounded-xl shadow-lg overflow-hidden w-full max-w-4xl mx-auto">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="/mindStone/public/img/hero.jpg" alt="Pilates Studio" class="w-full h-[300px] sm:h-[400px] md:h-[500px] object-cover" />
          </div>
          <div class="swiper-slide">
            <img src="/mindStone/public/img/mat.jpg" alt="Pilates Class" class="w-full h-[300px] sm:h-[400px] md:h-[500px] object-cover" />
          </div>
          <div class="swiper-slide">
            <img src="/mindStone/public/img/reformer.jpg" alt="Equipment" class="w-full h-[300px] sm:h-[400px] md:h-[500px] object-cover" />
          </div>
        </div>

        <!-- Optional controls -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>
  </div>
</section>

<!-- Horario -->
<section class="relative min-h-screen bg-brand-600 py-20">
  <div class="container">
    <h2 class="text-4xl md:text-5xl lg:text-6xl font-titulo text-white text-center drop-shadow-[0_2px_6px_rgba(0,0,0,0.7)]">
      <span class="text-white text-5xl mx-2">·</span>
      Our Class Schedule
      <span class="text-white text-5xl mx-2">·</span>
    </h2>
    <div class="absolute inset-0"></div>
    <div id="calendar" class="relative max-w-5xl mx-auto mt-12 p-6 rounded-xl bg-white backdrop-blur-md shadow-lg overflow-x-auto"></div>
  </div>
</section>

  <!-- Sección de Bonos-->
<section class="w-full bg-white py-20 px-4">
    <div class="container flex flex-col items-center">

    <!-- Título de la sección -->
    <h2 class="titulo-gradiente">
      <span class="titulo-punto">·</span>
      Our Prices <span class="titulo-punto">·</span>
    </h2>
    <!-- Contenedor de los bonos tipo grid, todos alineados verticalmente -->
    <div class="w-full max-w-7xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-7 mt-6">
      <!-- Unlimited Classes Card -->
      <div class="flex flex-col items-center bg-teal-100 p-8 rounded-lg shadow-lg max-w-sm" data-aos="fade-up"
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
        <button class="btn-cards">Join now</button>
      </div>
      <!-- 10 Classes Card -->
      <div class="flex flex-col items-center bg-teal-100 p-8 rounded-lg shadow-lg max-w-sm" data-aos="fade-up"
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
        <button class="btn-cards">Join now</button>
      </div>
      <!-- 4 Classes Card -->
      <div class="flex flex-col items-center bg-teal-100 p-8 rounded-lg shadow-lg max-w-sm" data-aos="fade-up"
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
        <button class="btn-cards">Join now</button>
      </div>
      <!-- 1 Class Card -->
      <div class="flex flex-col items-center bg-teal-100 p-8 rounded-lg shadow-lg max-w-sm" data-aos="fade-up"
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
        <button class="btn-cards">Join now</button>
      </div>
    </div>
    </div>
  </section>

  <!-- Sección de Contacto -->
  <section
    class="relative w-full min-h-[700px] flex items-center justify-center py-10 lg:py-24"
    style="background-image: url('/mindStone/public/img/bg-contacto.jpg'); background-size: cover; background-position: center;">
    <!-- Capa de opacidad usando color de marca -->
    <div class="absolute inset-0 bg-brand-300/20"></div>

    <!-- Contenido principal -->
    <div class="relative z-10 w-full max-w-7xl flex flex-col lg:flex-row items-center lg:items-stretch justify-between gap-8 px-4">
      <!-- Lado Derecho: Formulario de contacto -->
      <div class="flex-1 flex flex-col justify-center items-center" data-aos="fade-left">
        <form class="w-full max-w-md bg-transparent flex flex-col gap-4" id="cta-contact-form" novalidate>
          <!-- Nombre -->
          <div class="flex flex-col gap-1">
            <label for="name" class="text-brand-50 font-normal text-lg mb-1">Name <span class="text-brand-100">*</span></label>
            <input
              type="text"
              id="name"
              name="name"
              required
              placeholder="Your name"
              class="rounded-full px-6 py-2 bg-white/90 text-brand-950 font-normal placeholder-brand-200 focus:outline-brand-500 transition-all" />
            <span class="text-red-600 text-sm mt-1 hidden" id="name-error">Please enter a valid name (letters and spaces only).</span>
          </div>
          <!-- Email -->
          <div class="flex flex-col gap-1">
            <label for="email" class="text-brand-50 font-normal text-lg mb-1">Email <span class="text-brand-100">*</span></label>
            <input
              type="email"
              id="email"
              name="email"
              required
              placeholder="your@email.com"
              class="rounded-full px-6 py-2 bg-white/90 text-brand-950 font-normal placeholder-brand-200 focus:outline-brand-500 transition-all" />
            <span class="text-red-600 text-sm mt-1 hidden" id="email-error">Please enter a valid email address.</span>
          </div>
          <!-- Teléfono -->
          <div class="flex flex-col gap-1">
            <label for="phone" class="text-brand-50 font-normal text-lg mb-1">Phone <span class="text-brand-100">*</span></label>
            <input
              type="tel"
              id="phone"
              name="phone"
              required
              placeholder="Your phone"
              class="rounded-full px-6 py-2 bg-white/90 text-brand-950 font-normal placeholder-brand-200 focus:outline-brand-500 transition-all" />
            <span class="text-red-600 text-sm mt-1 hidden" id="phone-error">Please enter a valid phone number.</span>
          </div>
          <!-- Botón -->
          <button
            type="submit"
            class="btn-primary rounded-full">
            Send
          </button>
          <span class="text-green-700 text-base mt-2 hidden text-center" id="success-message">Thank you! We will contact you soon.</span>
        </form>
        <!-- Iconos de redes sociales -->
        <div class="flex gap-6 justify-center mt-8" data-aos="fade-up" data-aos-delay="200">
          <!-- WhatsApp -->
          <a href="https://wa.me/tu_numero" target="_blank" rel="noopener" aria-label="WhatsApp" class="text-white hover:text-brand-950 transition text-3xl">
            <!-- ...svg... -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" class="w-8 h-8">
              <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
            </svg>
          </a>
          <!-- Instagram -->
          <a href="https://instagram.com/tu_usuario" target="_blank" rel="noopener" aria-label="Instagram" class="text-white hover:text-brand-950 transition text-3xl">
            <!-- ...svg... -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" class="w-8 h-8"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
              <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
            </svg>
          </a>
          <!-- TikTok -->
          <a href="https://tiktok.com/@tu_usuario" target="_blank" rel="noopener" aria-label="TikTok" class="text-white hover:text-brand-950 transition text-3xl">
            <!-- ...svg... -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" class="w-8 h-8"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
              <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" />
            </svg>
          </a>
        </div>
      </div>

      <!-- Lado Izquierdo: Título y descripción -->
      <div class="flex-1 flex flex-col justify-center">
        <h2 class="font-titulo text-white text-[2.1rem] md:text-5xl lg:text-6xl leading-tight mb-6" data-aos="fade-right">
          Your Pilates studio<br>in Alicante.<br>Unlimited plans.
        </h2>
        <p class="text-brand-50 text-xl font-normal mb-2" data-aos="fade-right" data-aos-delay="100">
          Write to us for more information.
        </p>
      </div>
    </div>
  </section>

  <!-- Scripts JS, jquery y AOS -->
    <script src="/mindStone/app/lib/jquery-3.7.1.js"></script>
    <script src="/mindStone/public/js/login.js"></script>
    <script src="/mindStone/public/js/app.js"></script>
  <!-- Scripts JS AOS animaciones -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800,
            offset: 100,
            easing: 'ease-in-out',
        });
    </script>
  <!-- Script personalizado para iniciar Swiper -->
  <script>
    const swiper = new Swiper(".gallery-swiper", {
      loop: true,
      effect: "fade",
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  </script>

  <!-- Footer -->
  <?php require_once ROOT_PATH . '/app/views/layout/footer.php';?>
</body>
</html>
