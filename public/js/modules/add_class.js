document.addEventListener("DOMContentLoaded", () => {
  // 1. Cargar coaches dinámicamente
  fetch("/mindStone/app/models/getCoach.php")
    .then((response) => response.json())
    .then((data) => {
      const select = document.getElementById("coach");
      select.innerHTML = '<option value="">--Select a coach--</option>';
      data.forEach((coach) => {
        const option = document.createElement("option");
        option.value = coach.id;
        option.textContent = coach.name;
        select.appendChild(option);
      });
    })
    .catch((error) => console.error("Error loading coach:", error));

  // 2. Crear inputs para días de la semana y sus horarios
  const days = [
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
    "Sunday",
  ];
  const container = document.getElementById("days-schedules");

  days.forEach((day) => {
    const dayDiv = document.createElement("div");
    dayDiv.className = "mb-4 day-times-container"; //importante para limpieza posterior

    dayDiv.innerHTML = `
            <label class="flex items-center gap-2 text-brand-800 font-semibold">
                <input type="checkbox" name="days[${day}][enabled]" value="1" class="accent-brand-600">
                ${day}
            </label>
            <div id="times-${day}" class="ml-4 mt-2 hidden">
                <button type="button" onclick="addTime('${day}')" class="bg-brand-500 hover:bg-brand-600 text-white py-1 px-3 rounded text-sm mb-2">
                    + Add Time
                </button>
                <div class="time-inputs space-y-2"></div>
            </div>
        `;
    container.appendChild(dayDiv);
  });

  // 3. Mostrar u ocultar inputs según el checkbox
  container.addEventListener("change", (e) => {
    if (e.target.type === "checkbox" && e.target.name.includes("[enabled]")) {
      const day = e.target.name.match(/days\[(\w+)\]/)[1];
      const scheduleDiv = document.getElementById(`times-${day}`);
      scheduleDiv.classList.toggle("hidden", !e.target.checked);
    }
  });
});

// 4. Añadir campos de hora
function addTime(day) {
  const container = document.querySelector(`#times-${day} .time-inputs`);
  const inputWrapper = document.createElement("div");
  inputWrapper.className = "relative";

  const input = document.createElement("input");
  input.type = "time";
  input.name = `days[${day}][times][]`;
  input.required = true;
  input.className = "border border-brand-200 rounded p-1 pr-8";

  // (Opcional) Botón para eliminar ese campo horario
  const removeBtn = document.createElement("button");
  removeBtn.type = "button";
  removeBtn.textContent = "✕";
  removeBtn.className =
    "absolute right-1 top-1 text-sm text-red-500 hover:text-red-700";
  removeBtn.onclick = () => inputWrapper.remove();

  inputWrapper.appendChild(input);
  inputWrapper.appendChild(removeBtn);
  container.appendChild(inputWrapper);
}

// 5. Enviar formulario con feedback visual
document
  .getElementById("add-class-form")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const messageDiv = document.getElementById("form-message");
    const submitBtn = document.getElementById("submit-button");

    //Limpiar inputs vacíos ANTES de crear el FormData
    document
      .querySelectorAll('.time-inputs input[type="time"]')
      .forEach((input) => {
        if (!input.value) input.parentElement.remove(); // elimina el wrapper del input
      });

    submitBtn.disabled = true;
    messageDiv.textContent = "Saving class...";
    messageDiv.className = "mt-4 text-brand-600 font-semibold text-center";

    fetch("/mindStone/app/controllers/add_a_class_controller.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json()) // Asegúrate de convertir la respuesta a JSON
      .then((data) => {
        const messageDiv = document.getElementById("form-message");
        const submitBtn = document.getElementById("submit-button");

        const isSuccess = data.success; // Usamos el campo success del JSON

        messageDiv.textContent = data.message; // El mensaje que viene del backend
        messageDiv.className = `mt-4 text-center font-semibold ${
          isSuccess ? "text-green-600" : "text-red-600"
        }`; // Establece el color según el éxito

        if (isSuccess) {
          form.reset();
          document
            .querySelectorAll(".time-inputs")
            .forEach((div) => (div.innerHTML = ""));
          document
            .querySelectorAll("[id^='times-']")
            .forEach((div) => div.classList.add("hidden"));
        }
      })
      .catch((error) => {
        console.error("Error en el fetch:", error);
        const messageDiv = document.getElementById("form-message");
        messageDiv.textContent = "Error saving the class.";
        messageDiv.className = "mt-4 text-red-600 font-semibold text-center";
      })
      .finally(() => {
        submitBtn.disabled = false;
      });
  });
