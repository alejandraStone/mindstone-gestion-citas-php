/*
Archivo que contiene el código para crear, editar y eliminar usuarios en el panel de administración.
*/
// "/mindStone/public/js/modules/validations.js"; // Importa las validaciones
import {
  isValidName,
  isValidEmail,
  isValidInternationalPhone,
  isValidPassword,
} from "/mindStone/public/js/modules/validations.js";

document.addEventListener("DOMContentLoaded", () => {
  // ============================
  // UTILIDADES
  // ============================

  //muestra mensaje de error o éxito en el formulari
  const showMessage = (elementId, message, type = "error") => {
    const el = document.getElementById(elementId);
    el.textContent = message;
    el.className =
      "text-center mt-4 text-sm font-semibold " +
      (type === "success" ? "text-green-700" : "text-red-700");
  };
// Utilidad para hacer peticiones POST con JSON
  const jsonPost = async (url, data) => {
    const res = await fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    return await res.json();
  };

  // ============================
  // CREATE USER
  // ============================

  // Inicializa el formulario de creación de usuario y maneja la validación y envío de datos
  const initCreateUserForm = (formId = "add-user-form", msgId = "form-message") => {
    const form = document.getElementById(formId);
    if (!form) return;


    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      showMessage(msgId, "", ""); // Reset

      const formData = new FormData(form);
      const data = Object.fromEntries(formData.entries());

      if (!data.name || !data.lastName || !data.email || !data.phone || !data.password) {
        showMessage(msgId, "All fields are required.");
        return;
      }

      // Validaciones
      if (!isValidName(data.name))
        return showMessage(
          msgId,
          "First name must contain only letters and spaces."
        );
      if (!isValidName(data.lastName))
        return showMessage(
          msgId,
          "Last name must contain only letters and spaces."
        );
      if (!isValidEmail(data.email))
        return showMessage(msgId, "Invalid email format.");
      if (!isValidInternationalPhone(data.phone))
        return showMessage(
          msgId,
          "Phone number must start with '+' followed by 6 to 15 digits."
        );
      if (!isValidPassword(data.password))
        return showMessage(
          msgId,
          "Password must be at least 8 characters, including 1 uppercase letter, 1 number, and 1 special character."
        );

      data.action = "create";

      try {
        const result = await jsonPost(
          "/mindStone/app/controllers/user_crud_dashboard_controller.php",
          data
        );
        showMessage(
          msgId,
          result.message || "User created.",
          result.success ? "success" : "error"
        );
        if (result.success) {
          form.reset();
          location.reload(); // Solo recarga si éxito
        }
      } catch {
        showMessage(msgId, "Connection error.");
      }
    });
  };

  initCreateUserForm();

  // ============================
  // EDIT USER
  // ============================

  const openEditModal = (btn) => {
    document.getElementById("edit-user-id").value = btn.dataset.id;
    document.getElementById("edit-user-name").value = btn.dataset.name;
    document.getElementById("edit-user-lastname").value = btn.dataset.lastname;
    document.getElementById("edit-user-email").value = btn.dataset.email;
    document.getElementById("edit-user-phone").value = btn.dataset.phone;
    document.getElementById("edit-user-role").value = btn.dataset.role;
    document.getElementById("edit-user-modal").classList.remove("hidden");
  };

  document.querySelectorAll(".edit-class-btn").forEach((btn) => btn.addEventListener("click", () => openEditModal(btn)));

  document.getElementById("close-edit-user-modal")?.addEventListener("click", () => {
  document.getElementById("edit-user-modal").classList.add("hidden");});

  const editForm = document.getElementById("edit-user-form");
  if (editForm) {
    editForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const name = document.getElementById("edit-user-name").value.trim();
      const lastName = document.getElementById("edit-user-lastname").value.trim();
      const email = document.getElementById("edit-user-email").value.trim();
      const phone = document.getElementById("edit-user-phone").value.trim();
      const role = document.getElementById("edit-user-role").value;

      // Validación
      if (!name || !lastName || !email || !phone) {
        showMessage("edit-user-form-message", "All fields are required.", "error");
        return;
      }
      if (!isValidName(name)) {
        showMessage("edit-user-form-message", "First name must contain only letters and spaces.", "error");
        return;
      }
      if (!isValidName(lastName)) {
        showMessage("edit-user-form-message", "Last name must contain only letters and spaces.", "error");
        return;
      }
      if (!isValidEmail(email)) {
        showMessage("edit-user-form-message", "Invalid email format.", "error");
        return;
      }
      if (!isValidInternationalPhone(phone)) {
        showMessage("edit-user-form-message", "Phone number must start with '+' followed by 6 to 15 digits.", "error");
        return;
      }

      // Si todo está OK, envía los datos
      const data = {
        action: "update",
        id: document.getElementById("edit-user-id").value,
        name,
        lastName,
        email,
        phone,
        role,
      };

      try {
        const result = await jsonPost(
          "/mindStone/app/controllers/user_crud_dashboard_controller.php",
          data
        );
        if (result.success) {
          showMessage(
            "edit-user-form-message",
            result.message || "User updated successfully.",
            "success"
          );
          setTimeout(() => location.reload(), 1000);
        } else {
          showMessage(
            "edit-user-form-message",
            result.message || result.error || "Error updating user.",
            "error"
          );
        }
      } catch {
        showMessage("edit-user-form-message", "Connection error.", "error");
      }
    });
}

  // ============================
  // DELETE USER
  // ============================

  document.querySelectorAll(".btn-delete-user").forEach((btn) =>
    btn.addEventListener("click", async () => {
      if (!confirm("Are you sure you want to delete this user?")) return;//alert de confirmación

      try {
        const result = await jsonPost(
          "/mindStone/app/controllers/user_crud_dashboard_controller.php",
          {
            action: "delete",
            id: btn.dataset.id,
          }
        );
        if (result.success) {
          alert("User deleted successfully.");
          location.reload();
        } else {
          alert(result.message || "Error deleting user.");
        }
      } catch {
        alert("Connection error.");
      }
    })
  );

  // ============================
  // TOGGLE CREATE USER FORM PARA MOSTRAR/OCULTAR EL NOMBRE DEL BOTON
  // ============================

  const createUserBtn = document.getElementById("toggle-add-user");
  const createUserContainer = document.getElementById("create-user-container");

  if (createUserBtn && createUserContainer) {
    createUserBtn.addEventListener("click", async () => {
      if (createUserContainer.classList.contains("hidden")) {
        try {
          const res = await fetch("/mindStone/app/views/admin/create_user.php");
          const html = await res.text();
          createUserContainer.innerHTML = html;
          createUserContainer.classList.remove("hidden");
          initCreateUserForm(); // Reinicializar validaciones en el nuevo DOM
        } catch {
          alert("Error loading create form.");
        }
      } else {
        createUserContainer.classList.add("hidden");
      }
    });
  }
});
