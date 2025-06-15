/*
Archivo que maneja la lógica de la página de inicio, incluyendo animaciones y validación del formulario de contacto.
*/

// Importa las funciones de validación desde el archivo validaciones.js
import { isValidName, isValidEmail, isValidInternationalPhone } from "/mindStone/public/js/modules/validations.js";

// Todas las funciones jQuery agrupadas en un solo bloque
$(document).ready(function () {

  // --- Animaciones de la sección Hero ---
  setTimeout(function () {
    $("#hero-title")
      .removeClass("opacity-0 translate-y-12")//se elimina la clase de opacidad y desplazamiento
      .addClass("opacity-100 translate-y-0");//se hace visible y se coloca en su posición original
  }, 300);
  setTimeout(function () {
    $(".hero-btn")
      .removeClass("opacity-0 translate-y-12")//mismo proceso para los botones
      .addClass("opacity-100 translate-y-0");
  }, 700);

  //Animación de desplazamiento suave al hacer clic en el ícono del hero
  const trigger = document.getElementById("scroll-trigger");
  const target = document.getElementById("siguiente-seccion");

  if (trigger && target) {
    trigger.addEventListener("click", function (e) {
      e.preventDefault();
      target.scrollIntoView({ behavior: "smooth" });// Realiza el desplazamiento animado
    });
  }
 // --- Validación y envío AJAX del formulario de contacto ---
(function () {
  const form = document.getElementById("cta-contact-form");
  if (!form) return;

  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email_form_contact");
  const phoneInput = document.getElementById("phone");
  const messageInput = document.getElementById("message");
  const nameError = document.getElementById("name-error");
  const emailError = document.getElementById("email-error");
  const phoneError = document.getElementById("phone-error");
  const messageError = document.getElementById("message-error");
  const successMessage = document.getElementById("success-message");

  form.addEventListener("submit", function (e) {
    let valid = true;

    // Validar nombre
    if (!isValidName(nameInput.value.trim())) {
      nameError.classList.remove("hidden");
      valid = false;
    } else {
      nameError.classList.add("hidden");
    }

    // Validar email
    if (!isValidEmail(emailInput.value.trim())) {
      emailError.classList.remove("hidden");
      valid = false;
    } else {
      emailError.classList.add("hidden");
    }

    // Validar teléfono
    if (!isValidInternationalPhone(phoneInput.value.trim())) {
      phoneError.classList.remove("hidden");
      valid = false;
    } else {
      phoneError.classList.add("hidden");
    }

    // Validar mensaje
    if (!messageInput.value.trim()) {
      messageError.classList.remove("hidden");
      valid = false;
    } else {
      messageError.classList.add("hidden");
    }

    if (!valid) {
      e.preventDefault();
      if (successMessage) successMessage.classList.add("hidden");
      return false;
    } else {
      e.preventDefault(); // Previene el envío tradicional

      const formData = new FormData(form);
    //llamada AJAX para enviar el formulario
      fetch("/mindStone/app/controllers/user/send_contact_email_controller.php", {
        method: "POST",
        body: formData
      })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            if (successMessage) {
              successMessage.textContent = "Thank you! We will contact you soon.";
              successMessage.classList.remove("hidden");
              form.reset();
              setTimeout(() => {
                successMessage.classList.add("hidden");
              }, 4000);
            }
          } else {
            alert(data.message || "There was an error sending your message.");//alerta de error
          }
        })
        .catch(() => {
          alert("Unexpected error. Please try again.");
        });

      return false;
    }
  });

  // Validación en tiempo real para nombre
  if (nameInput) {
    nameInput.addEventListener("input", () => {
      if (isValidName(nameInput.value.trim())) {
        nameError.classList.add("hidden");
      }
    });
  }
  // Validación en tiempo real para email
  if (emailInput) {
    emailInput.addEventListener("input", () => {
      if (isValidEmail(emailInput.value.trim())) {
        emailError.classList.add("hidden");
      }
    });
  }
  // Validación en tiempo real para teléfono
  if (phoneInput) {
    phoneInput.addEventListener("input", () => {
      if (isValidInternationalPhone(phoneInput.value.trim())) {
        phoneError.classList.add("hidden");
      }
    });
  }
  // Validación en tiempo real para mensaje
  if (messageInput) {
    messageInput.addEventListener("input", () => {
      if (messageInput.value.trim()) {
        messageError.classList.add("hidden");
      }
    });
  }
})();
});

