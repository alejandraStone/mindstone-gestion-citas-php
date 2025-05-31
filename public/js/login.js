// Este script se encarga de abrir el modal para que un usuario se loguee y enviar la información al servidor por AJAX
// También se encarga de abrir el modal para recuperar la contraseña y enviar la información al servidor

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

  // Enviar login por AJAX con validaciones
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();
      loginForm.querySelectorAll(".ajax-msg").forEach((el) => el.remove());

      const messageBox = document.createElement("div");
      messageBox.className = "mb-4 text-center text-sm ajax-msg";

      const email = loginForm.querySelector('input[name="email"]').value.trim();
      const password = loginForm.querySelector('input[name="password"]').value;

      // Validar correo
      if (!email || !/^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
        messageBox.textContent = "Please enter a valid email address.";
        messageBox.classList.add("text-red-700");
        loginForm.insertBefore(messageBox, loginForm.firstChild);
        return;
      }

      // Validar que la contraseña no esté vacía
      if (!password) {
        messageBox.textContent = "Password cannot be empty.";
        messageBox.classList.add("text-red-700");
        loginForm.insertBefore(messageBox, loginForm.firstChild);
        return;
      }

      // Si pasa las validaciones, envía los datos al servidor
      const formData = new FormData(loginForm);
      fetch("/mindStone/app/controllers/auth/log_in_controller.php", {
        method: "POST",
        body: formData,
      })
        .then((r) => r.json())
        .then((data) => {
          messageBox.textContent = data.message;
          messageBox.classList.add(
            data.success ? "text-green-700" : "text-red-700"
          );
          loginForm.insertBefore(messageBox, loginForm.firstChild);

          if (data.success) {
            setTimeout(() => {
              loginModal.classList.add("hidden");
              if (data.role === "admin") {
                window.location.href =
                  "/mindStone/public/pages/admin/dashboard.php";
              } else {
                window.location.href =
                  "/mindStone/public/pages/reservations.php";
              }
            }, 800);
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

  // Cerrar forgot password modal al hacer clic fuera
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

      const email = document.getElementById("forgot_email").value.trim();

      // Validar email
      if (!email || !/^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
        forgotPasswordMsg.textContent = "Please enter a valid email address.";
        forgotPasswordMsg.className = "mt-4 text-center text-sm text-red-700";
        return;
      }

      // Enviar petición al servidor
      const formData = new FormData(forgotPasswordForm);
      fetch("/mindStone/app/controllers/forgot_password_controller.php", {
        method: "POST",
        body: formData,
      })
        .then((r) => r.json())
        .then((data) => {
          if (data.success && data.newPassword) {
            forgotPasswordMsg.innerHTML = `
              <span class="font-semibold">New password:</span> <span class="font-mono">${data.newPassword}</span><br>
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
