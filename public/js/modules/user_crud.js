document.addEventListener("DOMContentLoaded", function () {
  // ===== CREATE USER FUNCTIONALITY =====
  const addForm = document.getElementById("add-user-form");
  const msg = document.getElementById("form-message");

  function showFormMessage(message, type = "error") {
    msg.textContent = message;
    msg.className =
      "mt-4 text-center text-sm font-semibold " +
      (type === "success" ? "text-green-700" : "text-red-700");
  }

  if (addForm) {
    addForm.addEventListener("submit", function (e) {
      e.preventDefault();
      msg.textContent = "";
      msg.className = "mt-4 text-center text-sm font-semibold";

      // Recolectar los datos del formulario
      const formData = new FormData(addForm);
      const data = {};
      formData.forEach((value, key) => (data[key] = value));
      data.action = "create";

      fetch("/mindStone/app/controllers/user_crud_dashboard_controller.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
        .then((res) => res.json())
        .then((data) => {
          showFormMessage(data.message || "User created.", data.success ? "success" : "error");
          if (data.success) {
            addForm.reset();
          }
        })
        .catch(() => {
          showFormMessage("Error connecting to server.", "error");
        });
    });
  }

  // ======= EDIT USER MODAL =======
  document.querySelectorAll(".edit-class-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      document.getElementById("edit-user-id").value = this.dataset.id;
      document.getElementById("edit-user-name").value = this.dataset.name;
      document.getElementById("edit-user-lastname").value = this.dataset.lastname;
      document.getElementById("edit-user-email").value = this.dataset.email;
      document.getElementById("edit-user-phone").value = this.dataset.phone;
      document.getElementById("edit-user-role").value = this.dataset.role;
      document.getElementById("edit-user-modal").classList.remove("hidden");
    });
  });

  function showEditUserMessage(message, type = "error") {
    const msgDiv = document.getElementById("edit-user-form-message");
    msgDiv.textContent = message;
    msgDiv.className = "text-center font-semibold mt-2 " + (type === "success" ? "text-green-600" : "text-red-600");
  }

  // ======= CLOSE MODAL =======
  const closeBtn = document.getElementById("close-edit-user-modal");
  if (closeBtn) {
    closeBtn.addEventListener("click", function () {
      document.getElementById("edit-user-modal").classList.add("hidden");
    });
  }

  // ======= SUBMIT EDIT FORM =======
  const editForm = document.getElementById("edit-user-form");
  if (editForm) {
    editForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const id = document.getElementById("edit-user-id").value;
      const name = document.getElementById("edit-user-name").value;
      const lastName = document.getElementById("edit-user-lastname").value;
      const email = document.getElementById("edit-user-email").value;
      const phone = document.getElementById("edit-user-phone").value;
      const role = document.getElementById("edit-user-role").value;

      fetch("/mindStone/app/controllers/user_crud_dashboard_controller.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: "update",
          id,
          name,
          lastName,
          email,
          phone,
          role,
        }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            showEditUserMessage("User updated successfully!", "success");
            setTimeout(() => {
              document.getElementById("edit-user-form-message").textContent = "";
              document.getElementById("edit-user-modal").classList.add("hidden");
              location.reload();
            }, 1000);
          } else {
            showEditUserMessage(data.error || data.message || "Error updating user.", "error");
          }
        })
        .catch(() => {
          showEditUserMessage("Connection error.", "error");
        });
    });
  }

  // ======= DELETE USER =======
  document.querySelectorAll(".btn-delete-user").forEach((btn) => {
    btn.addEventListener("click", function () {
      const userId = this.dataset.id;
      if (!confirm("Are you sure you want to delete this user?")) return;
      fetch("/mindStone/app/controllers/user_crud_dashboard_controller.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "delete", id: userId }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            alert("User deleted successfully.");
            location.reload();
          } else {
            alert(data.error || data.message || "Error deleting user.");
          }
        })
        .catch(() => {
          alert("Connection error.");
        });
    });
  });

  // ======= RESET PASSWORD =======
  document.querySelectorAll(".btn-reset-user").forEach((btn) => {
    btn.addEventListener("click", function () {
      const userId = this.dataset.id;
      if (!confirm("Are you sure you want to reset the password for this user?")) return;
      fetch("/mindStone/app/controllers/user_crud_dashboard_controller.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "reset", id: userId }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            alert("Password reset successfully.\nNew password: " + data.newPassword);
            location.reload();
          } else {
            alert(data.error || data.message || "Error resetting password.");
          }
        })
        .catch(() => {
          alert("Connection error.");
        });
    });
  });
});