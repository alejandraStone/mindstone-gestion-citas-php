// --- FAQ acordeón ---
$(document).ready(function () {
  $('.faq-question').on('click', function () {
    var $faqItem = $(this).closest('.faq-item');
    var $answer = $faqItem.find('.faq-answer');
    var $arrow = $(this).find('.faq-arrow');

    if ($answer.is(':visible')) {
      $answer.slideUp(250);
      $arrow.removeClass('rotate-180');
    } else {
      // Cierra todas las respuestas abiertas
      $('.faq-answer:visible').slideUp(250);
      $('.faq-arrow').removeClass('rotate-180');

      // Abre solo la seleccionada
      $answer.slideDown(250);
      $arrow.addClass('rotate-180');
    }
  });
  //Animación de desplazamiento suave al hacer clic en el ícono del hero
  const trigger = document.getElementById("scroll-trigger");
  const target = document.getElementById("siguiente-seccion");

  if (trigger && target) {
    trigger.addEventListener("click", function (e) {
      e.preventDefault();
      target.scrollIntoView({ behavior: "smooth" });
    });
  }
});
