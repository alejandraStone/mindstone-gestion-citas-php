<?php
require_once __DIR__ . '/../app/config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/mindStone/public/css/output.css">
  <!-- CND Iconos de rrss -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- AOS libreria para animaciones con JS -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
  <title>Home</title>
</head>

<body class="font-normal pt-20 box-border overflow-x-hidden">
  <?php
  require_once ROOT_PATH . '/app/views/layout/header.php';
  ?>

  <!-- Hero Section -->
  <section class="relative h-[80vh] md:h-[80vh] lg:h-screen w-full">
    <div class="absolute inset-0 z-0">
      <img src="img/hero.jpg" alt="Pilates Class" class="w-full h-full object-cover brightness-75" />
    </div>
    <div class="relative z-10 flex items-center justify-center h-full text-center px-4 sm:px-6">
      <div class="max-w-[90%]">
        <h1 id="hero-title" class="titulo-grande text-white mb-6 opacity-0 translate-y-12 transition-all duration-1000">
          Transform Your Body <br class="hidden sm:block"> Elevate Your Mind
        </h1>
        <a id="hero-btn" href="<?= BASE_URL ?>app/views/user/reservations.php" class="opacity-0 translate-y-12 transition-all duration-700 inline-block px-6 py-2 border border-white text-white font-titulo sm:text-lg tracking-wide hover:bg-white hover:text-brand-800">
          BOOK NOW
        </a>
      </div>
    </div>
  </section>

  <!-- Bienvenida -->
  <section class="relative bg-brand-50 py-20 -mt-10 md:-mt-16 lg:-mt-24 mission-arc h-[50vh] md:h-[50vh] lg:h-[70vh] w-full flex flex-col items-center justify-center text-center">
    <!-- Texto bienvenida -->
    <div class="max-w-5xl mx-auto px-4 flex flex-col items-center gap-2 justify-center" data-aos="fade-up">
      <p class="font-normal font-extrabold text-black text-[24px] md:text-[28px] lg:text-[32px] leading-[35px] md:leading-[38px] lg:leading-[50px]">MINDSTONE A PILATES STUDIO IN THE HEART OF ALICANTE THAT YOU WILL LOVE, THAT WELCOMES YOU, HELPS YOU MOVE AND LOVES YOUR HARD WORK.</p>
      <span class="flex text-normal text-lg font-bold text-center gap-4 p-4 items-center">Lets' flow
        <a href="#siguiente-seccion" id="scroll-trigger">
          <svg class="w-4 animate-bounce" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 5.25 7.5 7.5 7.5-7.5m-15 6 7.5 7.5 7.5-7.5" />
          </svg>
        </a>
      </span>
    </div>
  </section>
  <!-- Servicios -->
  <section id="siguiente-seccion" class="relative bg-verdeOliva py-10 overflow-hidden">
    <!-- Overlay contenido dentro de un wrapper fijo -->
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-brand-100/30 via-transparent to-brand-200/30 z-0 pointer-events-none"></div>

    <!-- Contenedor principal -->
    <div class="relative z-10 max-w-7xl mx-auto p-4">

      <!-- Título principal -->
      <div class="flex items-center justify-center border border-white mb-10" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500"">
        <h2 class=" text-[32px] md:text-[40px] lg:text-[48px] font-titulo text-white text-center drop-shadow-[0_2px_6px_rgba(0,0,0,0.7)]">
        <span class="text-white text-5xl mx-2">·</span>
        Practice with Us
        <span class="text-white text-5xl mx-2">·</span>
        </h2>
      </div>

      <!-- Grid de servicios -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Servicio 1: Full Body -->
        <div class="flex flex-col border border-white p-4 rounded-xl bg-black/10" data-aos="fade-up"
          data-aos-duration="3000">
          <img src="img/full_body.jpg" alt="Full Body"
            class="object-cover w-full h-[300px] transition-transform duration-500 hover:scale-110 rounded-xl mb-4" />
          <div class="flex flex-col sm:flex-row justify-center items-stretch w-full">
            <h3 class="sm:w-1/2 text-white text-center p-4 border border-white">FULL BODY</h3>
            <a href="<?= BASE_URL ?>app/views/classes.php"
              class="sm:w-1/2 text-base flex items-center justify-center gap-2 text-white transition-all duration-500 hover:text-brand-400 border border-white">
              Explore Classes
              <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor"
                class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
              </svg>
            </a>
          </div>
        </div>

        <!-- Servicio 2: Mat -->
        <div class="flex flex-col border border-white p-4 rounded-xl bg-black/10" data-aos="fade-up"
          data-aos-duration="3000">
          <img src="img/mat.jpg" alt="Mat Class"
            class="object-cover w-full h-[300px] transition-transform duration-500 hover:scale-110 rounded-xl mb-4" />
          <div class="flex flex-col sm:flex-row justify-center items-stretch w-full">
            <h3 class="sm:w-1/2 text-white text-center p-4 border border-white">MAT</h3>
            <a href="<?= BASE_URL ?>app/views/classes.php"
              class="sm:w-1/2 text-base flex items-center justify-center gap-2 text-white transition-all duration-500 hover:text-brand-400 border border-white">
              Explore Classes
              <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor"
                class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
              </svg>
            </a>
          </div>
        </div>

        <!-- Servicio 3: Reformer -->
        <div class="flex flex-col border border-white p-4 rounded-xl bg-black/10" data-aos="fade-up"
          data-aos-duration="3000">
          <img src="img/reformer.jpg" alt="Reformer Class"
            class="object-cover w-full h-[300px] transition-transform duration-500 hover:scale-110 rounded-xl mb-4" />
          <div class="flex flex-col sm:flex-row justify-center items-stretch w-full">
            <h3 class="sm:w-1/2 text-white text-center p-4 border border-white">REFORMER</h3>
            <a href="<?= BASE_URL ?>app/views/classes.php"
              class="sm:w-1/2 text-base flex items-center justify-center gap-2 text-white transition-all duration-500 hover:text-brand-400 border border-white">
              Explore Classes
              <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor"
                class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
              </svg>
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Beneficions iconos -->
  <section class="bg-brand-50 flex flex-col md:flex-row lg:flex-row items-stretch justify-center w-full px-4 py-10 lg:py-24 gap-8">
    <!-- Beneficio 1 -->
    <div class="flex flex-col items-center justify-start text-center max-w-xs w-full px-4 
              transition duration-300 hover:shadow-[0_0_25px_#c1734c] hover:scale-105 rounded-xl">
      <img src="/mindStone/public/img/flor-de-loto.png" class="w-16 h-16">
      <p class="tamaño-subtitulo mt-2">Reduces stress</p>
      <p class="tamaño-texto-general mt-1">Through controlled breathing and mental focus, it helps reduce stress and improves oxygenation of the body.</p>
    </div>

    <!-- Beneficio 2 -->
    <div class="flex flex-col items-center justify-start text-center max-w-xs w-full px-4 
              transition duration-300 hover:shadow-[0_0_25px_#c1734c] hover:scale-105 rounded-xl">
      <img src="/mindStone/public/img/estera-de-yoga.png" class="w-16 h-16">
      <p class="tamaño-subtitulo mt-2">Increases flexibility</p>
      <p class="tamaño-texto-general mt-1">Exercises stretch and lengthen muscles, improving range of motion throughout the body.</p>
    </div>

    <!-- Beneficio 3 -->
    <div class="flex flex-col items-center justify-start text-center max-w-xs w-full px-4 
              transition duration-300 hover:shadow-[0_0_25px_#c1734c] hover:scale-105 rounded-xl">
      <img src="/mindStone/public/img/extendido.png" class="w-16 h-16">
      <p class="tamaño-subtitulo mt-2">Improves posture</p>
      <p class="tamaño-texto-general mt-1">Pilates strengthens the core and stabilising muscles, helping to maintain a correct and healthy posture.</p>
    </div>
  </section>

  <!-- About Estudio -->
  <section class="bg-brand-50 text-brand-900 pb-10 lg:pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 max-w-7xl mx-auto h-auto lg:h-[700px]">

      <!-- Columna izquierda -->
      <div class="flex flex-col h-full">

        <!-- Título -->
        <div class="flex border-t border-l border-r border-b-0 border-brand-900 p-4 md:p-6 lg:p-20 mx-4 lg:mx-0"
          data-aos="fade-right">
          <h2 class="titulo-gradiente text-center">
            <span class="titulo-punto">·</span>
            About the Studio
            <span class="titulo-punto">·</span>
          </h2>
        </div>

        <!-- Imagen SOLO en móvil y tablet -->
        <div class="block lg:hidden max-w-5xl h-[300px] md:h-[400px] overflow-hidden border-l border-r border-t border-b-0 border-brand-900 p-4 lg:px-0 mx-4">
          <img src="/mindStone/public/img/instalacion-principal.jpg" alt="Estudio de pilates"
            class="w-full h-full object-cover rounded-br-[4rem]">
        </div>

        <!-- T1 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 border border-t border-b border-l border-brand-900 flex-grow mx-4 lg:mx-0">
          <!-- Testimonio 1 -->
          <div class="p-4 md:p-6 border border-r border-b border-l-0 border-t-0 border-brand-900">
            <p class="font-bold mb-4">Top-Tier Instructors</p>

            <p>Certified, experienced, and passionate about your progress.</p>
          </div>

          <!-- T2 -->
          <div class="p-4 md:p-6 border border-r-0 border-b border-l-0 border-t-0 border-brand-900">
            <p class="font-bold mb-4">Premium Equipment</p>
            <p>Up to 8 reformers per class — space and comfort guaranteed.</p>
          </div>

          <!-- T3 -->
          <div class="p-4 md:p-6 border border-r sm:border-b md:border-b-0 lg:border-b-0 border-l-0 border-t-0 border-brand-900">
            <p class="font-bold mb-4">Prime Location</p>
            <p>Located in the heart of Salamanca neighborhood.</p>
          </div>

          <!-- T4 -->
          <div class="p-4 md:p-6">
            <p class="font-bold mb-4">Extra Comforts</p>
            <p>Towel rental & full changing rooms with showers available.</p>
            <a href="<?= BASE_URL ?>app/views/studio.php"
              class="w-1/2 text-sm flex items-center justify-start gap-2 transition-all duration-500 bg-verdeOliva text-black border hover:text-white border-black mt-4 rounded-full px-2 py-1">
              View Studio
              <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor"
                class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
              </svg>
            </a>
          </div>
        </div>
      </div>

      <!-- Imagen SOLO en desktop -->
      <div class="hidden lg:block w-full h-full overflow-hidden border-r border-t border-b border-brand-900 p-8" data-aos="fade-left">
        <img src="/mindStone/public/img/instalacion-principal.jpg" alt="Estudio de pilates"
          class="w-full h-full object-cover rounded-br-[8rem]">
      </div>
    </div>
  </section>

  <!-- Sección de Bonos-->
  <section class="w-full bg-brand-50 pt-10 pb-20 lg:pt-8 lg:pb-24 px-4">
    <div class="container flex flex-col items-center">

      <!-- Título de la sección -->
      <h2 class="titulo-gradiente mb-6">
        <span class="titulo-punto mr-2">·</span>
        Join the practice anytime<span class="titulo-punto ml-2">·</span>
      </h2>
      <!-- Contenedor de los bonos tipo grid, todos alineados verticalmente -->
      <div class="w-full max-w-7xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-7 mt-6">
        <!-- Unlimited Classes Card -->
        <div class="flex flex-col items-center bg-verdeOliva p-8 rounded-lg shadow-lg max-w-sm" data-aos="fade-up"
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
        <div class="flex flex-col items-center bg-verdeOliva p-8 rounded-lg shadow-lg max-w-sm" data-aos="fade-up"
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
        <!-- 4 Classes Card -->
        <div class="flex flex-col items-center bg-verdeOliva p-8 rounded-lg shadow-lg max-w-sm" data-aos="fade-up"
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
        <div class="flex flex-col items-center bg-verdeOliva p-8 rounded-lg shadow-lg max-w-sm" data-aos="fade-up"
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

  <!-- Sección de contacto-->
  <section id="contacto" class="relative text-brand-50 w-full min-h-screen overflow-hidden flex items-center"
    style="background-image: url('/mindStone/public/img/bg-contacto.jpg'); background-size: cover; background-position: center;">

    <!-- Overlay oscuro -->
    <div class="absolute inset-0 bg-black bg-opacity-20 z-0"></div>

    <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-2 gap-8 z-10 items-center">

      <!-- TEXTO E ÍCONOS -->
      <div class="flex flex-col justify-center w-full overflow-hidden">
        <h2 class="font-titulo text-white text-[2.1rem] md:text-5xl lg:text-6xl leading-tight mb-6" data-aos="fade-right">
          Your Pilates studio<br>in Alicante.<br>Unlimited plans.</h2>
        <ul class="flex flex-col gap-4 text-base" data-aos="fade-right">
          <li class="flex items-center gap-3">
            <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>

            <span class="truncate">Street example, Alicante, Spain</span>
          </li>
          <li class="flex items-center gap-3">
            <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>

            <span class="truncate">info@example.com</span>
          </li>
          <li class="flex items-center gap-3">
            <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
            </svg>
            <span class="truncate">666 987 654</span>
          </li>
        </ul>
      </div>

      <!-- FORMULARIO -->
      <div class="w-full flex justify-center items-center">
        <form class="w-full max-w-sm md:max-w-md lg:max-w-md mx-auto bg-transparent flex flex-col gap-4" id="cta-contact-form" novalidate data-aos="fade-left">

          <!-- Nombre -->
          <div class="flex flex-col gap-1 w-full">
            <label for="name" class="text-brand-50 font-normal text-lg mb-1">Name <span class="text-brand-100">*</span></label>
            <input
              type="text"
              id="name"
              name="name"
              required
              placeholder="Your name"
              class="w-full rounded-full px-4 py-2 bg-white/90 text-brand-950 placeholder-brand-200 focus:outline-brand-500 transition-all" />
            <span class="text-red-600 text-sm mt-1 hidden" id="name-error">Please enter a valid name (letters and spaces only).</span>
          </div>

          <!-- Email -->
          <div class="flex flex-col gap-1 w-full">
            <label for="email" class="text-brand-50 font-normal text-lg mb-1">Email <span class="text-brand-100">*</span></label>
            <input
              type="email"
              id="email"
              name="email"
              required
              placeholder="your@email.com"
              class="w-full rounded-full px-4 py-2 bg-white/90 text-brand-950 placeholder-brand-200 focus:outline-brand-500 transition-all" />
            <span class="text-red-600 text-sm mt-1 hidden" id="email-error">Please enter a valid email address.</span>
          </div>

          <!-- Teléfono -->
          <div class="flex flex-col gap-1 w-full">
            <label for="phone" class="text-brand-50 font-normal text-lg mb-1">Phone <span class="text-brand-100">*</span></label>
            <input
              type="tel"
              id="phone"
              name="phone"
              required
              placeholder="Your phone"
              class="w-full rounded-full px-4 py-2 bg-white/90 text-brand-950 placeholder-brand-200 focus:outline-brand-500 transition-all" />
            <span class="text-red-600 text-sm mt-1 hidden" id="phone-error">Please enter a valid phone number.</span>
          </div>

          <!-- Botón -->
          <button
            type="submit"
            class="btn-primary rounded-full w-1/2">
            Send
          </button>

          <span class="text-green-700 text-base mt-2 hidden text-center" id="success-message">Thank you! We will contact you soon.</span>
        </form>
      </div>

    </div>
  </section>
  <!-- Footer -->
  <?php require_once ROOT_PATH . '/app/views/layout/footer.php'; ?>

  <!-- Scripts JS, JQuery y AOS -->
  <script src="/mindStone/app/lib/jquery-3.7.1.js"></script>
  <script src="/mindStone/public/js/inicio.js"></script>
  <!-- Scripts JS AOS animaciones -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      once: true,
      duration: 1000,
      offset: 100,
      easing: 'ease-in-out',
    });
  </script>

</body>

</html>