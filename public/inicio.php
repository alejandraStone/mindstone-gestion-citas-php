<?php 
require_once __DIR__ . '/../app/config/config.php'; 
require_once ROOT_PATH . '/app/views/layout/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/mindStone/public/js/app.js"></script>
    <link rel="stylesheet" href="/mindStone/public/css/output.css">
    <title>Home</title>
</head>
    <body class="bg-brand-50 text-brand-900">

  <!-- Hero Section -->
  <section class="relative h-[90vh] sm:h-screen w-full">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
      <img src="img/hero.jpg" alt="Pilates Class" class="w-full h-full object-cover brightness-75" />
    </div>

    <!-- Overlay Content -->
    <div class="relative z-10 flex items-center justify-center h-full text-center px-4 sm:px-6">
      <div class="max-w-[90%]">
        <h1 class="text-white font-titulo text-3xl sm:text-5xl leading-tight mb-6">
          Transform Your Body. <br class="hidden sm:block"> Elevate Your Mind.
        </h1>
        <a href="#booking"
          class="inline-block px-6 py-2 border border-white text-white font-titulo sm:text-lg tracking-wide transition duration-300 hover:bg-white hover:text-brand-800">
          BOOK CLASS
        </a>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="px-4 py-10 bg-brand-50">

    <div class="max-w-4xl mx-auto text-center mb-12">
      <h2 class="text-2xl sm:text-3xl font-titulo mb-2">Our Pilates Classes</h2>
    </div>

    <div class="max-w-6xl mx-auto">
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">

        <!-- Servicio 1 -->
        <div class="card-services">
          <h3 class="text-lg font-titulo text-brand-900 mb-2">Full Body</h3>
          <div class="relative bg-white rounded-xl shadow-md">
            <img src="img/full_body.jpg" alt="Full Body" class="w-full h-56 object-cover brightness-90 rounded-xl" />
            <div class="absolute -bottom-5 left-1/2 -translate-x-1/2">
              <a href="#full-body"
                class="backdrop-blur bg-brand-100/40 border border-brand-500 text-brand-800 px-5 py-1.5 rounded-md flex items-center gap-2 text-sm font-semibold transition hover:bg-brand-100/60 hover:text-brand-950 shadow-lg">
                READ MORE
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                  </svg>
                </span>
              </a>
            </div>
          </div>
        </div>

        <!-- Servicio 2 -->
        <div class="card-services">
          <h3 class="text-lg font-titulo text-brand-900 mb-2">Mat</h3>
          <div class="relative bg-white rounded-xl shadow-md">
            <img src="img/mat.jpg" alt="Mat" class="w-full h-56 object-cover brightness-90 rounded-xl" />
            <div class="absolute -bottom-5 left-1/2 -translate-x-1/2">
              <a href="#full-body"
                class="backdrop-blur bg-brand-100/40 border border-brand-500 text-brand-800 px-5 py-1.5 rounded-md flex items-center gap-2 text-sm font-semibold transition hover:bg-brand-100/60 hover:text-brand-950 shadow-lg">
                READ MORE
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                  </svg>
                </span>
              </a>
            </div>
          </div>
        </div>

        <!-- Servicio 3 -->
        <div class="card-services">
          <h3 class="text-lg font-titulo text-brand-900 mb-2">Reformer</h3>
          <div class="relative bg-white rounded-xl shadow-md">
            <img src="img/reformer.jpg" alt="Reformer" class="w-full h-56 object-cover brightness-90 rounded-xl" />
            <div class="absolute -bottom-5 left-1/2 -translate-x-1/2">
              <a href="#full-body"
                class="backdrop-blur bg-brand-50/10 border border-brand-500 text-brand-800 px-5 py-1.5 rounded-md flex items-center gap-2 text-sm font-semibold transition hover:bg-brand-100/60 hover:text-brand-950 shadow-lg">
                READ MORE
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                  </svg>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>
</html>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/mindStone/app/views/layout/footer.php';?>
