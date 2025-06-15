/*
Archvio: classes.js
Código que permite el funcionamiento del acordeón de preguntas frecuentes (FAQ) y el scroll suave a la siguiente sección.
*/
// --- FAQ acordeón ---
$(document).ready(function () {
    // Se signa un evento de clic a cada elemento con la clase .faq-question
  $('.faq-question').on('click', function () {
        // Obtiene el elemento contenedor de toda la pregunta/respuesta
    var $faqItem = $(this).closest('.faq-item');
        // Obtiene el elemento de la respuesta asociada a la pregunta clicada
    var $answer = $faqItem.find('.faq-answer');
        // Obtiene el icono de flecha de la pregunta clicada
    var $arrow = $(this).find('.faq-arrow');

        // Si la respuesta ya está visible, la oculta y gira la flecha hacia arriba
    if ($answer.is(':visible')) {
      $answer.slideUp(250);//oculta animación
      $arrow.removeClass('rotate-180');//quita la rotación de la flecha
    } else {
      // Cierra todas las respuestas abiertas
      $('.faq-answer:visible').slideUp(250);
      $('.faq-arrow').removeClass('rotate-180');

      // Abre solo la respuesta seleccionada
      $answer.slideDown(250);
      $arrow.addClass('rotate-180');
    }
  });
  // Selecciona el trigger (icono) y la sección destino
  const trigger = document.getElementById("scroll-trigger");
  const target = document.getElementById("siguiente-seccion");
  // Si ambos elementos existen, añade el evento de clic para el scroll suave
  if (trigger && target) {
    trigger.addEventListener("click", function (e) {
      e.preventDefault();//previene el comportamiento por defecto
      target.scrollIntoView({ behavior: "smooth" });// Realiza el desplazamiento animado
    });
  }
});
