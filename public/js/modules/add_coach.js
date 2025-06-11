/*
Este archivo contiene todo el proceso para agregar un coach desde el dashboard.
Consulta por AJAX al servidor los datos y luego los muestra.
*/

// importo validaciones para el registro de usuario
import {
  isValidName,
  isValidEmail,
  isValidInternationalPhone,
} from "/mindStone/public/js/modules/validations.js";

// DOM Ready
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("add-coach-form");
  const messageElement = document.getElementById("form-message");
  const coachesList = document.getElementById("coaches-list");
  const addCoachBtn = document.getElementById("toggle-add-coach");

  if (!form || !addCoachBtn || !coachesList || !messageElement) return;

  form.classList.add("hidden");

  addCoachBtn.addEventListener("click", () => {
    form.classList.toggle("hidden");
    messageElement.textContent = "";
    addCoachBtn.textContent = form.classList.contains("hidden")
      ? "Add Coach"
      : "Hide Form";
  });

  form.addEventListener("submit", (event) => {
    event.preventDefault();
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) submitButton.disabled = true;

    const name = document.getElementById("edit-name").value.trim();
    const lastName = document.getElementById("edit-lastName").value.trim();
    const email = document.getElementById("edit-email").value.trim();
    const phone = document.getElementById("edit-phone").value.trim().replace(/\s+/g, "");

    
    // const name = form.name.value.trim();
    // const lastName = form.lastName.value.trim();
    // const email = form.email.value.trim();
    // const phone = form.phone.value.trim().replace(/\s+/g, "");

    const selectedSpecialities = form.querySelectorAll(
      'input[name="speciality[]"]:checked'
    );
    
      if (!name || !lastName || !email || !phone || selectedSpecialities.length === 0) {
        showMessage("All fields are required.", "red", submitButton);
        return;
      }

    if (!isValidName(name))
      return showMessage("First name must contain only letters and spaces.", "red", submitButton);
    if (!isValidName(lastName))
      return showMessage("Last name must contain only letters and spaces.", "red", submitButton);
    if (!isValidEmail(email))
      return showMessage("Invalid email format.", "red", submitButton);
    if (!isValidInternationalPhone(phone))
      return showMessage(
        "Phone number must start with '+' followed by 6 to 15 digits.",
        "red",
        submitButton
      );
    if (selectedSpecialities.length === 0)
      return showMessage(
        "Please select at least one speciality.",
        "red",
        submitButton
      );

    const formData = new FormData(form);

    fetch("/mindStone/app/controllers/add_coach_controller.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          showMessage(data.message, "green");
          form.reset();
          form.classList.add("hidden");
          addCoachBtn.textContent = "Add Coach";
          loadCoachesList();
        } else {
          showMessage(data.message || "Error adding coach.", "red");
        }
      })
      .catch((err) => showMessage("Error: " + err.message, "red"))
      .finally(() => {
        if (submitButton) submitButton.disabled = false;
      });
  });

  function showMessage(msg, color, btn) {
    messageElement.textContent = msg;
    messageElement.style.color = color;
    if (btn) btn.disabled = false;
    return false;
  }

  function loadCoachesList() {
    coachesList.innerHTML = `<div class="text-brand-700 text-center py-4">Loading...</div>`;
    fetch("/mindStone/app/controllers/get_coaches_by_speciality_controller.php")
      .then((res) => res.json())
      .then((data) => {
        if (
          data.success &&
          Array.isArray(data.coaches) &&
          data.coaches.length
        ) {
          coachesList.innerHTML = buildCoachesTable(data.coaches);
        } else {
          coachesList.innerHTML = `<div class="text-brand-500 text-center py-8">No coaches found.</div>`;
        }
      })
      .catch(() => {
        coachesList.innerHTML = `<div class="text-red-500 text-center py-8">Error loading coaches.</div>`;
      });
  }

  function buildCoachesTable(coaches) {
    return `
<table class="w-full min-w-[700px] table-auto border-separate border border-brand-200">
  <thead class="bg-brand-50 text-brand-700 text-sm uppercase text-left">
    <tr>
      <th class="px-4 py-3">Name</th>
      <th class="px-4 py-3">Email</th>
      <th class="px-4 py-3">Phone</th>
      <th class="px-4 py-3">Specialities</th>
      <th class="px-4 py-3 text-right">Actions</th>
    </tr>
  </thead>
  <tbody class="text-brand-900 divide-y divide-brand-100 text-sm">
    ${coaches
      .map(
        (coach) => `
    <tr class="hover:bg-brand-50">
      <td class="px-4 py-3 font-semibold">${coach.name} ${coach.lastName}</td>
      <td class="px-4 py-3">${coach.email}</td>
      <td class="px-4 py-3">${coach.phone}</td>
      <td class="px-4 py-3">${renderTags(coach.specialities)}</td>
      <td class="px-4 py-3 text-right">
        <button class="edit-coach-btn text-brand-600 hover:text-brand-900 font-medium text-sm mr-2" data-id="${
          coach.id
        }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            aria-hidden="true" data-slot="icon" class="w-5 h-5 text-brand-700">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
        </button>
        <button class="delete-coach-btn text-red-500 hover:text-red-700 font-medium text-sm" data-id="${coach.id}">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        aria-hidden="true" data-slot="icon" class="w-5 h-5 text-brand-700">
        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>
        </button>
      </td>
    </tr>`
      )
      .join("")}
  </tbody>
</table>`;
  }

  function getSpecialityColorClasses(name, variant = "label") {
    const map = {
      "Full Body": {
        label: "bg-lime-100 border-lime-200",
      },
      Mat: {
        label: "bg-emerald-100 border-emerald-200",
      },
      Reformer: {
        label: "bg-violet-100 border-violet-300",
      },
    };

    return map[name]?.[variant] || "bg-brand-50 border-brand-200";
  }

  function renderTags(specialities) {
    if (!specialities || !specialities.length)
      return `<span class="text-brand-400 italic">None</span>`;
    return specialities
      .map((sp) => {
        let color = "bg-brand-100 text-brand-800 border border-brand-200"; // default
        if (sp === "Full Body")
          color = "bg-lime-100 text-lime-800 border border-lime-300";
        else if (sp === "Mat")
          color = "bg-emerald-100 text-emerald-800 border border-emerald-300";
        else if (sp === "Reformer")
          color = "bg-violet-100 text-violet-800 border border-violet-300";
        return `<span class="inline-block text-xs px-2 py-1 rounded-full mr-1 mb-1 ${color}">${sp}</span>`;
      })
      .join("");
  }
  function getSpecialityColorClasses(name) {
    const colors = {
      "Full Body":
        "bg-lime-100 border-lime-200 peer-checked:bg-lime-100 peer-checked:border-lime-200",
      Mat: "bg-emerald-100 border-emerald-200 peer-checked:bg-emerald-100 peer-checked:border-emerald-200",
      Reformer:
        "bg-violet-100 border-violet-300 peer-checked:bg-violet-100 peer-checked:border-violet-300",
    };
    return (
      colors[name] ||
      "bg-brand-50 border-brand-200 peer-checked:bg-brand-50 peer-checked:border-brand-200"
    );
  }

  function renderSpecialities(allSpecialities, coachSpecialitiesIds) {
    specialitiesContainer.innerHTML = "";
    if (!allSpecialities.length) {
      specialitiesContainer.innerHTML = `<p class="text-sm text-red-400">No specialities available.</p>`;
      return;
    }

    allSpecialities.forEach((speciality) => {
      const isChecked = coachSpecialitiesIds.includes(speciality.id)
        ? "checked"
        : "";
      const colorClasses = getSpecialityColorClasses(speciality.name);

      const label = document.createElement("label");
      label.setAttribute("for", `speciality-${speciality.id}`);
      label.className = `flex items-center gap-3 p-3 rounded-xl border cursor-pointer group select-none hover:shadow transition ${colorClasses}`;

      label.innerHTML = `
      <input type="checkbox" name="speciality[]" value="${speciality.id}" class="hidden peer" id="speciality-${speciality.id}" ${isChecked} />
      <span class="flex items-center justify-center w-5 h-5 rounded-lg border-2 border-current bg-white peer-checked:opacity-100 transition">
        <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 20 20">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l4 4 6-7" />
        </svg>
      </span>
      <span class="text-brand-900 font-medium">${speciality.name}</span>
    `;
      specialitiesContainer.appendChild(label);
    });
  }
  // MODAL - Edit coach
  const editCoachModal = document.getElementById("edit-coach-modal");
  const editCoachForm = document.getElementById("edit-coach-form");
  const editCoachMessage = document.getElementById("edit-form-message");
  const specialitiesContainer = document.getElementById("edit-specialities-list");

  function renderSpecialities(allSpecialities, coachSpecialitiesIds) {
    specialitiesContainer.innerHTML = "";

    if (!allSpecialities.length) {
      specialitiesContainer.innerHTML = `<p class="text-sm text-red-400">No specialities available.</p>`;
      return;
    }

    allSpecialities.forEach((speciality) => {
      const isChecked = coachSpecialitiesIds.includes(speciality.id)
        ? "checked"
        : "";
      const checkboxColor = getSpecialityColorClasses(
        speciality.name,
        "checkbox"
      );

      const label = document.createElement("label");
      label.setAttribute("for", `speciality-${speciality.id}`);
      label.className = `flex items-center gap-3 p-3 rounded-xl border border-brand-200 hover:shadow transition cursor-pointer group select-none`;

      label.innerHTML = `
      <input type="checkbox" name="speciality[]" value="${speciality.id}" class="hidden peer" id="speciality-${speciality.id}" ${isChecked} />
      <span class="flex items-center justify-center w-5 h-5 rounded-lg border-2 transition-all duration-150 bg-white
        ${checkboxColor}">
        <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 20 20">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l4 4 6-7" />
        </svg>
      </span>
      <span class="text-brand-900 font-medium">${speciality.name}</span>`;
      specialitiesContainer.appendChild(label);
    });
  }

  // Funciones para abrir y cerrar modal limpias y reutilizables
  function openModal(modal) {
    modal.classList.remove("hidden");
    modal.classList.add("flex");
  }

  function closeModal(modal) {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
  }
  // Listener para abrir modal y cargar datos del coach
  coachesList.addEventListener("click", (e) => {
    const editBtn = e.target.closest(".edit-coach-btn");
    const deleteBtn = e.target.closest(".delete-coach-btn");

    // --- EDITAR ---
    if (editBtn) {
      const coachId = editBtn.dataset.id;
      if (!coachId) return;

      fetch("/mindStone/app/controllers/get_coach_by_id_controller.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ coach_id: coachId }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            const coach = data.coach;
            const allSpecialities = data.allSpecialities;
            const coachSpecialitiesIds = data.coachSpecialitiesIds;

            document.getElementById("coach-id").value = coach.id;
            editCoachForm.name.value = coach.name;
            editCoachForm.lastName.value = coach.lastName;
            editCoachForm.email.value = coach.email;
            editCoachForm.phone.value = coach.phone;

            renderSpecialities(allSpecialities, coachSpecialitiesIds);
            openModal(editCoachModal);
            editCoachMessage.textContent = "";
          } else {
            alert(data.message || "Error loading coach.");
          }
        });
    }

    // --- ELIMINAR ---
    if (deleteBtn) {
      const coachId = deleteBtn.dataset.id;
      if (!coachId) return;

      if (!confirm("Are you sure you want to delete this coach?")) return;

      fetch("/mindStone/app/controllers/delete_coach_controller.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ id: coachId }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            showMessage(data.message, "green");
            loadCoachesList(); // Recarga la lista
          } else {
            showMessage(data.message || "Error deleting coach.", "red");
          }
        })
        .catch(() => showMessage("Network error deleting coach.", "red"));
    }
  });

  // Listener para enviar formulario y actualizar coach
  editCoachForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const submitButton = editCoachForm.querySelector('button[type="submit"]');
    if (submitButton) submitButton.disabled = true;

    const name = editCoachForm.name.value.trim();
    const lastName = editCoachForm.lastName.value.trim();
    const email = editCoachForm.email.value.trim();
    const phone = editCoachForm.phone.value.trim().replace(/\s+/g, "");
    const selected = editCoachForm.querySelectorAll(
      'input[name="speciality[]"]:checked'
    );

    if (!isValidName(name))
      return showEditMessage("Invalid first name.", "red", submitButton);
    if (!isValidName(lastName))
      return showEditMessage("Invalid last name.", "red", submitButton);
    if (!isValidEmail(email))
      return showEditMessage("Invalid email address.", "red", submitButton);
    if (!isValidInternationalPhone(phone))
      return showEditMessage("Invalid phone number.", "red", submitButton);
    if (!selected.length)
      return showEditMessage(
        "Please select at least one speciality.",
        "red",
        submitButton
      );

    const formData = new FormData(editCoachForm);

    fetch("/mindStone/app/controllers/edit_coach_controller.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          showEditMessage(
            data.message || "Coach updated successfully.",
            "green"
          );
          setTimeout(() => {
            editCoachForm.reset();
            editCoachModal.classList.add("hidden");
            loadCoachesList();
            editCoachMessage.textContent = "";
          }, 2000);
        } else {
          showEditMessage(data.message || "Error updating coach.", "red");
        }
      })
      .catch((err) => showEditMessage("Error: " + err.message, "red"))
      .finally(() => {
        if (submitButton) submitButton.disabled = false;
      });
  });

  function showEditMessage(msg, color, btn) {
    editCoachMessage.textContent = msg;
    editCoachMessage.style.color = color;
    if (btn) btn.disabled = false;
    return false;
  }

  function openModal(modal) {
    modal.classList.remove("hidden");
    modal.classList.add("flex");
  }
  // Listener para cerrar modal con el botón de cerrar (X)
  document.getElementById("close-edit-modal").addEventListener("click", () => {
    editCoachModal.classList.add("hidden");
    editCoachModal.classList.remove("flex");
    editCoachMessage.textContent = "";
  });

  loadCoachesList(); // Initial load
});
