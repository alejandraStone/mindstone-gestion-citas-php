// Este script se encarga de abrir el modal para que un usuario se loguee y enviar la información al servidor
// También se encarga de abrir el modal para recuperar la contraseña y enviar la información al servidor

// Este script gestiona la apertura de los modales de login y recuperación de contraseña
// y el envío AJAX de ambos formularios

document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.querySelector("#loginModal form");
  const loginModal = document.getElementById("loginModal");
  const loginBtn = document.getElementById("loginBtn");
  const closeLoginModal = document.getElementById("closeLoginModal");
  const forgotPasswordBtn = document.getElementById("forgotPasswordBtn");
  const forgotPasswordModal = document.getElementById("forgotPasswordModal");
  const closeForgotPasswordModal = document.getElementById(
    "closeForgotPasswordModal"
  );
  const forgotPasswordForm = document.getElementById("forgotPasswordForm");
  const forgotPasswordMsg = document.getElementById("forgotPasswordMsg");

  // Mostrar login modal
  if (loginBtn)
    loginBtn.addEventListener("click", () => {
      loginModal.classList.remove("hidden");
      // Limpia mensajes al abrir
      if (loginForm)
        loginForm.querySelectorAll(".ajax-msg").forEach((el) => el.remove());
    });
  // Cerrar login modal
  if (closeLoginModal)
    closeLoginModal.addEventListener("click", () =>
      loginModal.classList.add("hidden")
    );
  // Cerrar login modal al hacer clic fuera de él
  if (loginModal)
    loginModal.addEventListener("click", (e) => {
      if (e.target === loginModal) loginModal.classList.add("hidden");
    });

  // Enviar login por AJAX
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();
      // Elimina mensajes anteriores
      loginForm.querySelectorAll(".ajax-msg").forEach((el) => el.remove());

      // Crea el messageBox cada vez
      const messageBox = document.createElement("div");
      messageBox.className = "mb-4 text-center text-sm ajax-msg";

      const formData = new FormData(loginForm);
      fetch("/mindStone/app/controllers/log_in_controller.php", {
        method: "POST",
        body: formData,
      })
        .then((r) => r.json())
        .then((data) => {
          if (data.success) {
            messageBox.textContent = data.message;
            messageBox.classList.add("text-green-700");
            loginForm.insertBefore(messageBox, loginForm.firstChild);
            setTimeout(() => {
              loginModal.classList.add("hidden");
              // Redirige según el rol
              if (data.role === "admin") {
                window.location.href =
                  "/mindStone/app/views/admin/dashboard.php";
              } else {
                window.location.href = "/mindStone/public/inicio.php";
              }
            }, 800);
          } else {
            messageBox.textContent = data.message;
            messageBox.classList.add("text-red-700");
            loginForm.insertBefore(messageBox, loginForm.firstChild);
          }
        })
        .catch(() => {
          messageBox.textContent = "Unexpected error. Please try again.";
          messageBox.classList.add("text-red-700");
          loginForm.insertBefore(messageBox, loginForm.firstChild);
        });
    });
  }

  // Mostrar forgot password modal
  if (forgotPasswordBtn)
    forgotPasswordBtn.addEventListener("click", () => {
      loginModal.classList.add("hidden");
      forgotPasswordModal.classList.remove("hidden");
      forgotPasswordMsg.textContent = "";
      forgotPasswordForm.reset();
    });
  // Cerrar forgot password modal
  if (closeForgotPasswordModal)
    closeForgotPasswordModal.addEventListener("click", () =>
      forgotPasswordModal.classList.add("hidden")
    );
  // Cerrar forgot password modal al hacer clic fuera de él
  if (forgotPasswordModal)
    forgotPasswordModal.addEventListener("click", (e) => {
      if (e.target === forgotPasswordModal)
        forgotPasswordModal.classList.add("hidden");
    });

  // Enviar forgot password por AJAX
  if (forgotPasswordForm) {
    forgotPasswordForm.addEventListener("submit", function (e) {
      e.preventDefault();
      forgotPasswordMsg.textContent = "";
      const formData = new FormData(forgotPasswordForm);
      fetch("/mindStone/app/controllers/forgot_password_controller.php", {
        method: "POST",
        body: formData,
      })
        .then((r) => r.json())
        .then((data) => {
          // Si el backend devuelve la contraseña en data.newPassword
          if (data.success && data.newPassword) {
            forgotPasswordMsg.innerHTML = `
                    <span class="font-semibold">Nueva contraseña:</span> <span class="font-mono">${data.newPassword}</span><br>
                    <span class="text-green-700">${data.message}</span>
                `;
            forgotPasswordMsg.className =
              "mt-4 text-center text-sm text-green-700";
          } else {
            forgotPasswordMsg.textContent = data.message;
            forgotPasswordMsg.className =
              "mt-4 text-center text-sm text-red-700";
          }
          })
        .catch(() => {
          forgotPasswordMsg.textContent = "Unexpected error. Please try again.";
          forgotPasswordMsg.className = "mt-4 text-center text-sm text-red-700";
        });
    });
  }
});
