import {
  isValidName,
  isValidEmail,
  isValidInternationalPhone,
  isValidPassword,
} from "/mindStone/public/js/modules/validations.js";

document.addEventListener("DOMContentLoaded", () => {
  // ============================
  // UTILS
  // ============================

  const showMessage = (elementId, message, type = "error") => {
    const el = document.getElementById(elementId);
    el.textContent = message;
    el.className =
      "text-center mt-4 text-sm font-semibold " +
      (type === "success" ? "text-green-700" : "text-red-700");
  };

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

  const initCreateUserForm = (
    formId = "add-user-form",
    msgId = "form-message"
  ) => {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      showMessage(msgId, "", ""); // Reset

      const formData = new FormData(form);
      const data = Object.fromEntries(formData.entries());

      if (
        !data.name ||
        !data.lastName ||
        !data.email ||
        !data.phone ||
        !data.password
      ) {
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
        if (result.success) form.reset();
        location.reload(); // recarga todo y la tabla se ve actualizada
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

      const data = {
        action: "update",
        id: document.getElementById("edit-user-id").value,
        name: document.getElementById("edit-user-name").value,
        lastName: document.getElementById("edit-user-lastname").value,
        email: document.getElementById("edit-user-email").value,
        phone: document.getElementById("edit-user-phone").value,
        role: document.getElementById("edit-user-role").value,
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
        showMessage("edit-user-form-message", "Connection error.");
      }
    });
  }

  // ============================
  // DELETE USER
  // ============================

  document.querySelectorAll(".btn-delete-user").forEach((btn) =>
    btn.addEventListener("click", async () => {
      if (!confirm("Are you sure you want to delete this user?")) return;

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
  // TOGGLE CREATE USER FORM
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
