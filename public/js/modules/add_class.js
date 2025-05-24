// Espera a que el DOM esté cargado
document.addEventListener("DOMContentLoaded", () => {
  // --- VARIABLES PARA FORMULARIO DE ALTA ---
  const select = document.getElementById("coach");
  const pilatesTypeSelect = document.getElementById("pilates-type");
  const capacityInput = document.getElementById("capacity");
  let occupiedHours = {};
  let selectedHours = {};

  // --- VARIABLES PARA MODAL DE EDICIÓN ---
  let pilatesTypesOptions = [];

  // --- VARIABLES PARA MOSTRAR EL BLOQUE DE TODAS LAS CLASES ---
  const toggleBtn = document.getElementById("toggle-class-list");
  const classListSection = document.getElementById("class-list-section");
  let visible = false;

  // --- FUNCION PARA MOSTRAR U OCULTAR EL LISTADO DE CLASES ---
  toggleBtn.addEventListener("click", function () {
    visible = !visible;
    classListSection.classList.toggle("hidden", !visible);
    toggleBtn.textContent = visible ? "Hide Classes" : "Show Classes";
  });
  // --- FUNCIONES AUXILIARES ---
  function normalizeHour(hourStr) {
    return hourStr && hourStr.length >= 5 ? hourStr.slice(0, 5) : hourStr;
  }

  //Mapeo del tipo de clase a color pastel (no brand, pero combinan con la paleta tailwind)
  const typeColorMap = {
    Yoga: "bg-emerald-100 border-emerald-300",
    Pilates: "bg-sky-100 border-sky-300",
    Stretch: "bg-orange-100 border-orange-300",
    Reformer: "bg-violet-100 border-violet-300",
    Barre: "bg-rose-100 border-rose-300",
    Funcional: "bg-lime-100 border-lime-300",
    "Full Body": "bg-lime-100 border-lime-200",
    Mat: "bg-emerald-100 border-emerald-200",
    Default: "bg-gray-100 border-gray-300",
  };

  function getClassBg(typeName) {
    for (const key in typeColorMap) {
      if (typeName && typeName.toLowerCase().includes(key.toLowerCase())) {
        return typeColorMap[key];
      }
    }
    return typeColorMap["Default"];
  }

  // --- CARGA OPCIONES DE TIPO (para el alta y el modal) ---
  async function loadPilatesTypes() {
    const res = await fetch(
      "/mindStone/app/controllers/get_all_specialities_controller.php"
    );
    const data = await res.json();
    pilatesTypesOptions = data.specialities || [];
    return pilatesTypesOptions;
  }

  // --- CARGA COACHES POR ESPECIALIDAD ---
  async function loadCoachesBySpeciality(
    specialityId,
    selectElement,
    selectedValue = null
  ) {
    selectElement.innerHTML = '<option value="">Loading coaches</option>';
    if (!specialityId) {
      selectElement.innerHTML = '<option value="">--Select a coach--</option>';
      return;
    }
    try {
      const res = await fetch(
        `/mindStone/app/controllers/get_coaches_by_speciality_controller.php?speciality_id=${specialityId}`
      );
      const data = await res.json();
      selectElement.innerHTML = '<option value="">--Select a coach--</option>';
      if (
        !data.success ||
        !Array.isArray(data.coaches) ||
        data.coaches.length === 0
      ) {
        selectElement.innerHTML += `<option disabled>There are no coaches for this type</option>`;
      } else {
        data.coaches.forEach((coach) => {
          const option = document.createElement("option");
          option.value = coach.id;
          option.textContent = coach.name;
          if (selectedValue && selectedValue == coach.id)
            option.selected = true;
          selectElement.appendChild(option);
        });
      }
    } catch (error) {
      console.error("Error loading coach:", error);
      selectElement.innerHTML =
        "<option disabled>Error loading coaches</option>";
    }
  }

  function fillSelectOptions(
    select,
    options,
    selectedValue,
    keyId = "id",
    keyName = "name"
  ) {
    select.innerHTML = "";
    options.forEach((opt) => {
      const option = document.createElement("option");
      option.value = opt[keyId];
      option.textContent = opt[keyName];
      if (opt[keyId] == selectedValue) option.selected = true;
      select.appendChild(option);
    });
  }

  // --- LOGICA DEL FORMULARIO DE ALTA ---
  async function loadSpecialitiesForCreate() {
    const types = await loadPilatesTypes();
    pilatesTypeSelect.innerHTML =
      '<option value="">--Select class type--</option>';
    types.forEach((spec) => {
      const opt = document.createElement("option");
      opt.value = spec.id;
      opt.textContent = spec.name;
      pilatesTypeSelect.appendChild(opt);
    });
  }

  pilatesTypeSelect.addEventListener("change", () => {
    const selectedType = pilatesTypeSelect.value;
    loadCoachesBySpeciality(selectedType, select);
  });

  const daysOfWeek = [
    { key: "Monday", label: "Monday" },
    { key: "Tuesday", label: "Tuesday" },
    { key: "Wednesday", label: "Wednesday" },
    { key: "Thursday", label: "Thursday" },
    { key: "Friday", label: "Friday" },
    { key: "Saturday", label: "Saturday" },
    { key: "Sunday", label: "Sunday" },
  ];
  const agendaGrid = document.getElementById("agenda-grid");

  pilatesTypeSelect.addEventListener("change", loadOccupiedHours);
  select.addEventListener("change", loadOccupiedHours);

  function loadOccupiedHours() {
    const pilates_type = pilatesTypeSelect.value;
    const coach = select.value;
    if (!pilates_type || !coach) {
      renderWeeklyAgenda();
      return;
    }
    fetch(
      `/mindStone/app/controllers/get_occupied_schedules.php?pilates_type=${encodeURIComponent(
        pilates_type
      )}&coach=${encodeURIComponent(coach)}`
    )
      .then((res) => res.json())
      .then((data) => {
        occupiedHours = {};
        if (data.success && Array.isArray(data.occupied)) {
          data.occupied.forEach(({ day, hour }) => {
            if (!occupiedHours[day]) occupiedHours[day] = [];
            occupiedHours[day].push(normalizeHour(hour));
          });
        }
        renderWeeklyAgenda();
      });
  }

  function renderWeeklyAgenda() {
    agendaGrid.innerHTML = "";
    daysOfWeek.forEach((dayObj) => {
      const day = dayObj.key;
      const dayDiv = document.createElement("div");
      dayDiv.className =
        "bg-white border border-brand-200 rounded-lg p-4 flex flex-col items-center min-h-[148px]";

      // Cabecera día
      const dayLabel = document.createElement("div");
      dayLabel.className = "font-semibold mb-2 text-brand-800";
      dayLabel.textContent = dayObj.label;
      dayDiv.appendChild(dayLabel);

      // Lista de horas seleccionadas
      const selected = selectedHours[day] || [];
      const selectedList = document.createElement("ul");
      selectedList.className = "mb-2 space-y-1 w-full";
      selected.forEach((hour) => {
        const li = document.createElement("li");
        li.className = "flex items-center gap-2 text-brand-900";
        li.textContent = hour;
        const btn = document.createElement("button");
        btn.type = "button";
        btn.textContent = "✕";
        btn.className =
          "ml-2 text-sm text-red-500 hover:text-red-700 rounded focus:outline-none";
        btn.onclick = () => removeHour(day, hour);
        li.appendChild(btn);
        selectedList.appendChild(li);
      });
      dayDiv.appendChild(selectedList);

      // Input para agregar nueva hora (al hacer Enter o blur)
      const timeInput = document.createElement("input");
      timeInput.type = "time";
      timeInput.className =
        "w-full h-10 px-3 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition mb-1";
      timeInput.placeholder = "Add hour";
      timeInput.addEventListener("change", tryAddHour);
      timeInput.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
          tryAddHour();
        }
      });

      function tryAddHour() {
        const hour = timeInput.value;
        if (!hour) return;
        if ((occupiedHours[day] || []).includes(hour)) {
          alert("¡This timetable is already occupied!");
          timeInput.value = "";
          return;
        }
        if ((selectedHours[day] || []).includes(hour)) {
          alert("¡You have already added that time!");
          timeInput.value = "";
          return;
        }
        addHour(day, hour);
        timeInput.value = "";
      }

      dayDiv.appendChild(timeInput);

      // Mostrar debajo las horas ocupadas (gris)
      const occ = occupiedHours[day] || [];
      if (occ.length > 0) {
        const occDiv = document.createElement("div");
        occDiv.className = "text-xs text-brand-300 mt-1";
        occDiv.textContent = "Class already added: " + occ.join(", ");
        dayDiv.appendChild(occDiv);
      }

      agendaGrid.appendChild(dayDiv);
    });
  }

  function addHour(day, hour) {
    if (!selectedHours[day]) selectedHours[day] = [];
    selectedHours[day].push(hour);
    renderWeeklyAgenda();
  }
  function removeHour(day, hour) {
    selectedHours[day] = selectedHours[day].filter((h) => h !== hour);
    renderWeeklyAgenda();
  }

  document
    .getElementById("add-class-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const pilates_type = pilatesTypeSelect.value;
      const capacity = capacityInput.value;
      const coach = select.value;
      const messageDiv = document.getElementById("form-message");
      const submitBtn = document.getElementById("submit-button");

      const days = {};
      Object.entries(selectedHours).forEach(([day, hours]) => {
        if (hours.length > 0) {
          days[day] = { enabled: true, times: hours };
        }
      });

      if (
        !pilates_type ||
        !coach ||
        !capacity ||
        Object.keys(days).length === 0
      ) {
        messageDiv.textContent =
          "All fields and at least one hour are mandatory.";
        messageDiv.className = "mt-4 text-red-600 font-semibold text-center";
        return;
      }

      const formData = new FormData();
      formData.append("pilates_type", pilates_type);
      formData.append("coach", coach);
      formData.append("capacity", capacity);
      formData.append("days", JSON.stringify(days));

      submitBtn.disabled = true;
      messageDiv.textContent = "Saving class...";
      messageDiv.className = "mt-4 text-brand-600 font-semibold text-center";

      fetch("/mindStone/app/controllers/add_a_class_controller.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          const isSuccess = data.success;
          messageDiv.textContent = data.message;
          messageDiv.className = `mt-4 text-center font-semibold ${
            isSuccess ? "text-green-600" : "text-red-600"
          }`;

          if (isSuccess) {
            selectedHours = {};
            renderWeeklyAgenda();
            document.getElementById("add-class-form").reset();
            select.innerHTML = '<option value="">--Select a coach--</option>';
            fetchAndRenderClassList();
          }
        })
        .catch((error) => {
          console.error("Error en el fetch:", error);
          messageDiv.textContent = "Error saving the class.";
          messageDiv.className = "mt-4 text-red-600 font-semibold text-center";
        })
        .finally(() => {
          submitBtn.disabled = false;
        });
    });

  // --- FILTRADO Y LISTADO DE CLASES EN CALENDARIO ---
  let allClasses = [];
  let filterType = "";
  let filterDay = "";

  function renderClassFilters(types) {
    // --- TYPE ---
    const typeList = document.getElementById("filter-type-list");
    typeList.innerHTML = "";
    typeList.className = "grid grid-cols-2 gap-2 sm:flex sm:gap-2";

    const allBtn = document.createElement("button");
    allBtn.textContent = "All";
    const isAllType = !filterType || filterType === "";
    allBtn.className = `px-3 py-1 rounded-full border text-sm font-medium
    ${
      isAllType
        ? "bg-white text-brand-800 border-brand-200"
        : "bg-white text-brand-800 border-brand-200"
    }
    hover:bg-brand-100 transition`;
    //bg-brand-600 text-white" : "bg-white text-brand-800 border-brand-200
    allBtn.onclick = () => {
      filterType = "";
      applyClassFilters();
    };
    typeList.appendChild(allBtn);

    types.forEach((type) => {
      // Comparación estricta, normalizando a lower case y quitando espacios
      const isSelected =
        (filterType || "").toLowerCase().trim() ===
        (type.name || "").toLowerCase().trim();
      const btn = document.createElement("button");
      btn.textContent = type.name;
      btn.className = `px-3 py-1 rounded-full border text-sm font-medium
      ${
        isSelected
          ? "bg-brand-600 text-white"
          : "bg-white text-brand-800 border-brand-200"
      }
      hover:bg-brand-100 transition`;
      btn.onclick = () => {
        filterType = type.name;
        applyClassFilters();
      };
      typeList.appendChild(btn);
    });

    // --- DÍA ---
    const dayList = document.getElementById("filter-day-list");
    dayList.innerHTML = "";
    dayList.className = "grid grid-cols-2 gap-2 sm:flex sm:gap-2";

    const allDayBtn = document.createElement("button");
    allDayBtn.textContent = "All";
    const isAllDay = !filterDay || filterDay === "";
    allDayBtn.className = `px-3 py-1 rounded-full border text-sm font-medium
    ${
      isAllDay
        ? "bg-brand-600 text-white"
        : "bg-white text-brand-800 border-brand-200"
    }
    hover:bg-brand-100 transition`;
    allDayBtn.onclick = () => {
      filterDay = "";
      applyClassFilters();
    };
    dayList.appendChild(allDayBtn);

    [
      { key: "Monday", label: "Monday" },
      { key: "Tuesday", label: "Tuesday" },
      { key: "Wednesday", label: "Wednesday" },
      { key: "Thursday", label: "Thursday" },
      { key: "Friday", label: "Friday" },
      { key: "Saturday", label: "Saturday" },
      { key: "Sunday", label: "Sunday" },
    ].forEach((day) => {
      const isSelected =
        (filterDay || "").toLowerCase().trim() ===
        (day.key || "").toLowerCase().trim();
      const btn = document.createElement("button");
      btn.textContent = day.label;
      btn.className = `px-3 py-1 rounded-full border text-sm font-medium
      ${
        isSelected
          ? "bg-brand-600 text-white"
          : "bg-white text-brand-800 border-brand-200"
      }
      hover:bg-brand-100 transition`;
      btn.onclick = () => {
        filterDay = day.key;
        applyClassFilters();
      };
      dayList.appendChild(btn);
    });
  }

  function applyClassFilters() {
    let filtered = allClasses.slice();
    if (filterType) {
      filtered = filtered.filter(
        (cls) =>
          (cls.pilates_type_name || "").toLowerCase().trim() ===
          filterType.toLowerCase().trim()
      );
    }
    if (filterDay) {
      filtered = filtered.filter(
        (cls) =>
          (cls.day || "").toLowerCase().trim() ===
          filterDay.toLowerCase().trim()
      );
    }
    renderCalendarClassList(filtered);
  }

  function renderCalendarClassList(classes) {
    const daysOfWeek = [
      { key: "Monday", label: "Monday" },
      { key: "Tuesday", label: "Tuesday" },
      { key: "Wednesday", label: "Wednesday" },
      { key: "Thursday", label: "Thursday" },
      { key: "Friday", label: "Friday" },
      { key: "Saturday", label: "Saturday" },
      { key: "Sunday", label: "Sunday" },
    ];
    const calendar = document.getElementById("calendar-class-list");
    calendar.innerHTML = "";

    // Agrupa las clases por día
    const grouped = {};
    daysOfWeek.forEach((day) => (grouped[day.key] = []));
    classes.forEach((cls) => {
  if (typeof cls.day === "string") {
    const dayNormalized = cls.day.charAt(0).toUpperCase() + cls.day.slice(1).toLowerCase();
    if (grouped[dayNormalized]) {
      grouped[dayNormalized].push(cls);
    } else {
      console.warn(`Día no reconocido para agrupar: "${cls.day}" normalizado como "${dayNormalized}"`, cls);
    }
  } else {
    console.warn("Clase sin propiedad day válida:", cls);
  }
});
    console.log("Clases agrupadas:", grouped); //depurar para ver si se agrupan bien los días

    // Calendario grid: 7 columnas fijas en desktop
    const calendarGrid = document.createElement("div");
    calendarGrid.className = `
    grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4 lg:gap-1
    w-full max-w-7xl mx-auto
  `.replace(/\s+/g, " ");

    daysOfWeek.forEach((day) => {
      const col = document.createElement("div");
      col.className =
        "rounded-xl p-2 bg-brand-300 flex flex-col h-full min-h-[350px]";

      const header = document.createElement("div");
      header.className =
        "font-bold mb-4 text-center text-brand-900 uppercase tracking-wide text-base";
      header.textContent = day.label;
      col.appendChild(header);

      if (grouped[day.key].length === 0) {
        const empty = document.createElement("div");
        empty.className = "text-brand-50 text-sm text-center py-8";
        empty.textContent = "No classes";
        col.appendChild(empty);
      } else {
        grouped[day.key].forEach((cls) => {
          const colorBg = getClassBg(cls.pilates_type_name || cls.pilates_type);
          const block = document.createElement("div");
          block.className = `
          ${colorBg} border rounded-lg mb-4 p-4 shadow
          flex flex-col gap-1 text-sm w-full
          transition hover:scale-105 hover:shadow-lg
        `.replace(/\s+/g, " ");
          block.innerHTML = `
          <div class="font-semibold text-brand-900">${cls.pilates_type_name}</div>
          <div class="text-brand-800">
            <span class="inline-block mr-1">⏰</span>
            ${cls.hour}
          </div>
          <div class="text-brand-700">Capacity: ${cls.capacity}</div>
          <div class="text-brand-700">Coach: ${cls.coach_name}</div>
          <div class="flex gap-2 mt-2">
            <button class="edit-class-btn border border-brand-200 text-brand-900 bg-white rounded px-3 py-1 text-xs hover:bg-brand-100" data-id="${cls.id}">Edit</button>
            <button class="delete-class-btn border border-red-100 text-red-600 bg-white rounded px-3 py-1 text-xs hover:bg-red-100" data-id="${cls.id}">Delete</button>
          </div>
        `;
          block.querySelector(".edit-class-btn").onclick = () =>
            openEditModal(cls);
          block.querySelector(".delete-class-btn").onclick = () =>
            deleteClass(cls.id);
          col.appendChild(block);
        });
      }
      calendarGrid.appendChild(col);
    });

    calendar.appendChild(calendarGrid);
  }

  function openEditModal(cls) {
    let loadTypesPromise =
      pilatesTypesOptions.length === 0
        ? loadPilatesTypes().then((types) => (pilatesTypesOptions = types))
        : Promise.resolve(pilatesTypesOptions);

    loadTypesPromise.then(() => {
      const editPilatesTypeSelect =
        document.getElementById("edit-pilates-type");
      fillSelectOptions(
        editPilatesTypeSelect,
        pilatesTypesOptions,
        cls.pilates_type
      );

      const editCoachSelect = document.getElementById("edit-coach");
      loadCoachesBySpeciality(cls.pilates_type, editCoachSelect, cls.coach);

      document.getElementById("edit-class-id").value = cls.id;
      document.getElementById("edit-capacity").value = cls.capacity;
      document.getElementById("edit-day").value = cls.day;
      document.getElementById("edit-hour").value = cls.hour;
      document.getElementById("edit-form-message").textContent = "";
      document.getElementById("edit-class-modal").classList.remove("hidden");

      editPilatesTypeSelect.onchange = () =>
        loadCoachesBySpeciality(editPilatesTypeSelect.value, editCoachSelect);
    });
  }
  // --- EDITAR Y BORRAR ---

  document.getElementById("close-edit-modal").onclick = () =>
  document.getElementById("edit-class-modal").classList.add("hidden");

  document.getElementById("edit-class-form").onsubmit = async function (e) {
    e.preventDefault();
    const id = document.getElementById("edit-class-id").value;
    const pilates_type = document.getElementById("edit-pilates-type").value;
    const coach = document.getElementById("edit-coach").value;
    const capacity = document.getElementById("edit-capacity").value;
    const day = document.getElementById("edit-day").value;
    const hour = document.getElementById("edit-hour").value;
    const msg = document.getElementById("edit-form-message");

    if (!pilates_type || !coach || !capacity || !day || !hour) {
      msg.textContent = "All fields are mandatory";
      msg.className = "text-center text-red-600 font-semibold";
      return;
    }
    msg.textContent = "Saving...";

    const res = await fetch(
      "/mindStone/app/controllers/edit_lesson_controller.php",
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, pilates_type, coach, capacity, day, hour }),
      }
    );
    const data = await res.json();
    msg.textContent = data.message;
    if (data.success) {
      msg.classList.remove("text-red-600");
      msg.classList.add("text-green-600");

      setTimeout(() => {
        document.getElementById("edit-class-modal").classList.add("hidden");
        fetchAndRenderClassList();
      }, 1000);
    } else {
      msg.classList.remove("text-green-600");
      msg.classList.add("text-red-600");
    }
  };
  // --- BORRAR CLASE --
  async function deleteClass(id) {
    // Confirmation before deleting
    if (!confirm("Are you sure you want to delete this class?")) return;

    try {
      const response = await fetch(
        "/mindStone/app/controllers/delete_lesson_controller.php",
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id }),
        }
      );
      const data = await response.json();
      if (data.success) {
        alert("The class was successfully deleted!");
        fetchAndRenderClassList();
      } else {
        alert(data.message || "Could not delete the class.");
      }
    } catch (err) {
      alert("Error deleting class: " + err.message);
      console.error("Error deleting class:", err.message);
    }
  }

  // --- INICIALIZACIÓN ---
  loadSpecialitiesForCreate();
  renderWeeklyAgenda();
  fetchAndRenderClassList();

  // --- ACTUALIZA FILTROS Y CALENDARIO CUANDO SE CARGAN LAS CLASES ---
  async function fetchAndRenderClassList() {
    try {
      const [classRes, typeRes] = await Promise.all([
        fetch(
          "/mindStone/app/controllers/get_all_lessons_controller.php?limit=100&offset=0"
        ).then((r) => r.json()),
        fetch(
          "/mindStone/app/controllers/get_all_specialities_controller.php"
        ).then((r) => r.json()),
      ]);
      allClasses = (classRes.lessons || []).map((lesson) => ({
        id: lesson.id,
        pilates_type: lesson.pilates_type,
        pilates_type_name: lesson.pilates_type_name || lesson.pilates_type,
        day: lesson.day,
        hour: lesson.hour,
        capacity: lesson.capacity,
        coach: lesson.coach,
        coach_name: lesson.coach_name || lesson.coach,
      }));
      const types = typeRes.specialities || [];
      console.log("Tipos que llegan al filtro:", types);

      renderClassFilters(types);
      applyClassFilters();
    } catch (err) {
      renderClassFilters([]);
      renderCalendarClassList([]);
    }
  }
});
