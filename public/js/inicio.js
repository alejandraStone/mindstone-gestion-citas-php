// Todas las funciones jQuery agrupadas en un solo bloque
$(document).ready(function () {

  // --- Animaciones de la sección Hero ---
  setTimeout(function () {
    $("#hero-title")
      .removeClass("opacity-0 translate-y-12")
      .addClass("opacity-100 translate-y-0");
  }, 300);
  setTimeout(function () {
    $("#hero-btn")
      .removeClass("opacity-0 translate-y-12")
      .addClass("opacity-100 translate-y-0");
  }, 700);

  //Animación de desplazamiento suave al hacer clic en el ícono del hero
  const trigger = document.getElementById("scroll-trigger");
  const target = document.getElementById("siguiente-seccion");

  if (trigger && target) {
    trigger.addEventListener("click", function (e) {
      e.preventDefault();
      target.scrollIntoView({ behavior: "smooth" });
    });
  }
  // --- Validación del formulario de contacto con expresiones regulares ---
  (function () {
    const form = document.getElementById("cta-contact-form");
    if (!form) return;
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");
    const nameError = document.getElementById("name-error");
    const emailError = document.getElementById("email-error");
    const phoneError = document.getElementById("phone-error");
    const successMessage = document.getElementById("success-message");

    // Expresiones regulares para validación
    const nameRegex = /^[A-Za-zÀ-ÿ\s]{2,50}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[\d\s\-\+\(\)]{7,20}$/;

    form.addEventListener("submit", function (e) {
      let valid = true;

      // Validar nombre (solo letras y espacios, mínimo 2 caracteres)
      if (!nameRegex.test(nameInput.value.trim())) {
        nameError.classList.remove("hidden");
        valid = false;
      } else {
        nameError.classList.add("hidden");
      }

      // Validar email
      if (!emailRegex.test(emailInput.value.trim())) {
        emailError.classList.remove("hidden");
        valid = false;
      } else {
        emailError.classList.add("hidden");
      }

      // Validar teléfono (dígitos, espacios, guiones, paréntesis, +, mínimo 7 caracteres)
      if (!phoneRegex.test(phoneInput.value.trim())) {
        phoneError.classList.remove("hidden");
        valid = false;
      } else {
        phoneError.classList.add("hidden");
      }

      if (!valid) {
        e.preventDefault();
        if (successMessage) successMessage.classList.add("hidden");
        return false;
      } else {
        e.preventDefault(); //evita el envío real
        if (successMessage) {
          successMessage.classList.remove("hidden");
          form.reset();
          //ocultar mensaje después de unos segundos
          setTimeout(() => {
            successMessage.classList.add("hidden");
          }, 4000);
        }
        return false;
      }
    });

    // Validación en tiempo real
    if (nameInput) {
      nameInput.addEventListener("input", () => {
        if (nameRegex.test(nameInput.value.trim())) {
          nameError.classList.add("hidden");
        }
      });
    }
    if (emailInput) {
      emailInput.addEventListener("input", () => {
        if (emailRegex.test(emailInput.value.trim())) {
          emailError.classList.add("hidden");
        }
      });
    }
    if (phoneInput) {
      phoneInput.addEventListener("input", () => {
        if (phoneRegex.test(phoneInput.value.trim())) {
          phoneError.classList.add("hidden");
        }
      });
    }
  })();
  // --- Animación de las cards de servicios al hacer scroll ---
  /*
    function initCardAnimations() {
    // Usa Intersection Observer si está disponible, si no, fallback con scroll
    if ('IntersectionObserver' in window) {
      const observer = new window.IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            $(entry.target).removeClass('opacity-0 translate-y-10')
                            .addClass('opacity-100 translate-y-0');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });
      $('.card-services').each(function () {
        // Asegura que las clases iniciales de animación estén puestas si no existen
        $(this).addClass('opacity-0 translate-y-10 transition-all duration-700');
        observer.observe(this);
      });
    } else {
      // Fallback para navegadores antiguos
      $('.card-services').each(function () {
        $(this).removeClass('opacity-0 translate-y-10')
               .addClass('opacity-100 translate-y-0');
      });
    }
  }
  
  // --- Animación de la sección Misión al hacer scroll ---
  function animateMission() {
    var windowBottom = $(window).scrollTop() + $(window).height() - 60;
    // Animar texto
    var $text = $('#mission-text');
    if ($text.length && $text.offset().top < windowBottom) {
      $text.removeClass('opacity-0 -translate-x-10').addClass('opacity-100 translate-x-0');
    }
    // Animar imagen
    var $img = $('#mission-img');
    if ($img.length && $img.offset().top < windowBottom) {
      $img.removeClass('opacity-0 translate-x-10').addClass('opacity-100 translate-x-0');
    }
  }
  // Asegura que las clases iniciales de animación estén puestas si no existen
  $('#mission-text').addClass('opacity-0 -translate-x-10 transition-all duration-1000');
  $('#mission-img').addClass('opacity-0 translate-x-10 transition-all duration-1000');
  // Ejecutar la animación al cargar y al hacer scroll
  animateMission();
  $(window).on('scroll', animateMission);
*/

  // --- Inicializaciones de funciones globales ---
  //initCardAnimations();
  //animateMission();
});
