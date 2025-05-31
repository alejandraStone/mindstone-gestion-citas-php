// JS para el registro de usuario normal usando controlador que recibe JSON y "action: create".

document.addEventListener("DOMContentLoaded", function () {
  // Obtener el formulario y el div de mensajes
  const signupForm = document.getElementById("formSignup");
  const signupMsg = document.getElementById("signupMsg");

  // Función para mostrar mensajes al usuario
  function showSignupMessage(message, type = "error") {
    signupMsg.textContent = message;
    signupMsg.className =
      "mt-6 text-center text-sm font-semibold " +
      (type === "success" ? "text-green-700" : "text-red-700");
  }

  if (signupForm) {
    signupForm.addEventListener("submit", function (e) {
      e.preventDefault();
      signupMsg.textContent = "";
      signupMsg.className = "mt-6 text-center text-sm font-semibold";

      // Recolectar los datos del formulario manualmente (no FormData, sino objeto JS)
      const data = {
        action: "create",
        name: signupForm.name.value.trim(),
        lastName: signupForm.lastName.value.trim(),
        email: signupForm.email.value.trim(),
        phone: signupForm.phone.value.trim(),
        password: signupForm.password.value,
        role: "user",
        context: 'signup'// Contexto para el controlador que la creación es desde el signup
      };

      // Enviar los datos como JSON al controlador
      fetch("/mindStone/app/controllers/user_crud_dashboard_controller.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
        .then((res) => res.json())
        .then((data) => {
            console.log('Respuesta backend:', data);
          showSignupMessage(data.message || "Registration completed.", data.success ? "success" : "error");
          // Si el registro es exitoso, limpiar y redirigir
          if (data.success) {
            signupForm.reset();
            setTimeout(() => {
              window.location.href = "/mindStone/public/pages/reservations.php"; // Lo llevo a la página de reservas
            }, 1500);
          }
        })
        .catch(() => {
          showSignupMessage("Error connecting to the server.", "error");
        });
    });
  }
});