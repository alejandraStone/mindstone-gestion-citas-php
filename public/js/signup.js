// JS para el registro de usuario normal usando controlador que recibe JSON y "action: create".

document.addEventListener("DOMContentLoaded", function () {
  const signupForm = document.getElementById("formSignup");
  const signupMsg = document.getElementById("signupMsg");

  function showSignupMessage(message, type = "error") {
    signupMsg.textContent = message;
    signupMsg.className =
      "mt-6 text-center text-sm font-semibold " +
      (type === "success" ? "text-green-700" : "text-red-700");
  }

  // Validadores específicos
  function isValidName(name) {
    // Solo letras y espacios, sin números ni caracteres extraños
    return /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s'-]+$/.test(name);
  }

  function isValidEmail(email) {
    // Validación básica de email
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function isValidInternationalPhone(phone) {
    // Empieza con +, seguido de entre 6 y 15 dígitos
    return /^\+\d{6,15}$/.test(phone);
  }

  function isValidPassword(password) {
    // Mínimo 8 caracteres, al menos 1 mayúscula, 1 número y 1 carácter especial
    return /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};:'",.<>\/?\\|`~])[A-Za-z\d!@#$%^&*()_\-+=\[\]{};:'",.<>\/?\\|`~]{8,}$/.test(
      password
    );
  }

  if (signupForm) {
    signupForm.addEventListener("submit", function (e) {
      e.preventDefault();
      signupMsg.textContent = "";
      signupMsg.className = "mt-6 text-center text-sm font-semibold";

      const name = signupForm.name.value.trim();
      const lastName = signupForm.lastName.value.trim();
      const email = signupForm.email.value.trim();
      const phone = signupForm.phone.value.trim().replace(/\s+/g, ""); // Eliminar espacios
      const password = signupForm.password.value;

      if (!name || !lastName || !email || !phone || !password) {
        showSignupMessage("All fields are required.");
        return;
      }
      // Validar campos vacíos
      if (!name) {
        showSignupMessage("First name cannot be empty.");
        return;
      }
      if (!isValidName(name)) {
        showSignupMessage("First name must contain only letters and spaces.");
        return;
      }

      if (!lastName) {
        showSignupMessage("Last name cannot be empty.");
        return;
      }
      if (!isValidName(lastName)) {
        showSignupMessage("Last name must contain only letters and spaces.");
        return;
      }

      if (!email) {
        showSignupMessage("Email cannot be empty.");
        return;
      }
      if (!isValidEmail(email)) {
        showSignupMessage("Invalid email format.");
        return;
      }

      if (!phone) {
        showSignupMessage("Phone number cannot be empty.");
        return;
      }
      if (!isValidInternationalPhone(phone)) {
        showSignupMessage(
          "Phone number must start with '+' followed by 6 to 15 digits."
        );
        return;
      }

      if (!password) {
        showSignupMessage("Password cannot be empty.");
        return;
      }
      if (!isValidPassword(password)) {
        showSignupMessage(
          "Password must be at least 8 characters, including 1 uppercase letter, 1 number, and 1 special character."
        );
        return;
      }

      // Datos para enviar
      const data = {
        action: "create",
        name: name,
        lastName: lastName,
        email: email,
        phone: phone,
        password: password,
        role: "user",
        context: "signup",
      };

      fetch("/mindStone/app/controllers/user_crud_dashboard_controller.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
        .then((res) => res.json())
        .then((data) => {
          console.log("Respuesta backend:", data);
          showSignupMessage(
            data.message || "Registration completed.",
            data.success ? "success" : "error"
          );
          if (data.success) {
            signupForm.reset();
            setTimeout(() => {
              window.location.href = "/mindStone/public/pages/reservations.php";
            }, 1500);
          }
        })
        .catch(() => {
          showSignupMessage("Error connecting to the server.", "error");
        });
    });
  }
});
