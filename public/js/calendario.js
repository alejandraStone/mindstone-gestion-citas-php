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

async function loadCalendar() {
  const res = await fetch(
    "/mindStone/app/controllers/user/get_all_lessons_controller.php"
  );
  const classes = await res.json();

  const calendar = document.getElementById("calendar");
  const days = [
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
    "Sunday",
  ];

  const timetable = {};
  const hoursSet = new Set();
  days.forEach((day) => {
    timetable[day] = {};
  });

  classes.forEach((cl) => {
    const hourKey = cl.hour.substring(0, 5);
    hoursSet.add(hourKey);
    if (!timetable[cl.day]) timetable[cl.day] = {};
    if (!timetable[cl.day][hourKey]) timetable[cl.day][hourKey] = [];
    timetable[cl.day][hourKey].push(cl);
  });

  const hours = Array.from(hoursSet).sort();

  const table = document.createElement("table");
  table.className = "min-w-full border-collapse text-sm font-normal";

  // Header
  const thead = document.createElement("thead");
  thead.innerHTML = `
    <tr class="bg-brand-800 text-white uppercase tracking-wide text-center font-normal">
      <th class="p-3 sticky left-0 bg-brand-800 z-10 text-left font-titulo">Time</th>
      ${days
        .map((day) => `<th class="p-3 border-l border-brand-800">${day}</th>`)
        .join("")}
    </tr>
  `;
  table.appendChild(thead);

  // Body
  const tbody = document.createElement("tbody");

  hours.forEach((hour) => {
    const tr = document.createElement("tr");
    tr.className = "hover:bg-brand-100";

    const th = document.createElement("th");
    th.className =
      "p-2 sticky left-0 bg-white/50 backdrop-blur-sm font-titulo text-brand-700";
    th.textContent = hour;
    tr.appendChild(th);

    days.forEach((day) => {
      const td = document.createElement("td");
      td.className = "p-2 border border-brand-200 align-top min-w-[120px]";
      const lessons = timetable[day][hour] || [];

      if (lessons.length === 0) {
        td.innerHTML = '<span class="text-brand-400 italic">-</span>';
      } else {
        lessons.forEach((lesson) => {
          const colorClass =
            typeColorMap[lesson.pilates_type_name] || typeColorMap.Default;

          const lessonDiv = document.createElement("div");
          lessonDiv.className = `${colorClass} border rounded-md p-2 mb-2 shadow-md transition transform hover:scale-105 hover:shadow-lg cursor-pointer`;
          lessonDiv.setAttribute("data-aos", "fade-up");
          lessonDiv.setAttribute("data-aos-delay", "100");
          lessonDiv.setAttribute("data-lesson-id", lesson.id); //Agregar el ID de la clase para la reserva

          lessonDiv.innerHTML = `
          <div class="font-semibold">${lesson.pilates_type_name}</div>
          <div class="text-xs font-normal text-brand-700 mb-1">Coach: ${lesson.coach_name}</div>
          <div class="text-[11px] text-center text-brand-800 bg-white border border-brand-200 rounded px-2 py-0.5 w-fit mx-auto shadow-sm hover:bg-brand-700 hover:text-white transition">
            Reserve
          </div>
        `;

          //obtengo el ID del usuario actual desde el main
          const currentUserId =
            document.querySelector("main")?.dataset.userId || null;

          //Añado el evento de click para reservar la clase
          lessonDiv.addEventListener("click", async () => {
            const lessonId = lessonDiv.getAttribute("data-lesson-id");

            // Si no está logueado, redirige al login
            if (!currentUserId) {
              // Mostrar el modal de login
              const loginModal = document.getElementById("loginModal");
              if (loginModal) {
                loginModal.classList.remove("hidden");
              } else {
                showToast("Login modal not found.");
              }
              return;
            }
            // Mostrar toast de confirmación
            const confirmed = await showToast(
              "Do you want to reserve this class?",
              { confirm: true }
            );
            if (!confirmed) return;
            console.log("User ID:", currentUserId);
            console.log("Lesson ID:", lessonId);
            // Enviar reserva
            fetch("/mindStone/app/controllers/user/book_class_controller.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded",
              },
              body: `lesson_id=${encodeURIComponent(
                lessonId
              )}&user_id=${encodeURIComponent(currentUserId)}`,
            })
              .then((response) => response.json())
              .then((data) => {
                showToast(data.message); // Mensaje claro para el usuario
                if (data.dev_message) {
                  console.error("Dev message:", data.dev_message); // Mensaje para desarrollo en consola
                }
              })
              .catch((error) => {
                showToast("Something went wrong.");
                console.error("Fetch error:", error);
              });
          });
          td.appendChild(lessonDiv);
        });
      }
      tr.appendChild(td);
    });

    tbody.appendChild(tr);
  });

  table.appendChild(tbody);
  calendar.appendChild(table);

  //Al final se quita la clase .empty para que vuelva el overflow-x-auto real
  calendar.classList.remove("empty");

  if (typeof AOS !== "undefined") {
    AOS.init({ once: true });
  }
  //muestra el mes y año actual en el calendario
  const monthDisplay = document.getElementById("monthDisplay");
  if (monthDisplay) {
    const today = new Date();
    const monthNames = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    const monthName = monthNames[today.getMonth()];
    const year = today.getFullYear();
    monthDisplay.textContent = `Month: ${monthName} ${year}`;
  }
}
//funcion para mostrar un toast de éxito o error de la reserva
function showToast(message, options = {}) {
  // Crear overlay oscuro
  const overlay = document.createElement("div");
  overlay.className =
    "fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40";
  document.body.appendChild(overlay);

  // Crear el toast
  const toast = document.createElement("div");
  toast.className = `
    fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
    bg-white text-gray-900 p-6 rounded-xl shadow-xl border w-80 z-50
    opacity-0 scale-95 transition-all duration-300
  `;

  // Mostrar mensaje
  if (options.confirm) {
    toast.innerHTML = `
      <p class="mb-4 text-center text-lg font-medium">${message}</p>
      <div class="flex justify-center gap-4">
        <button id="toast-cancel" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Cancel</button>
        <button id="toast-confirm" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">Confirm</button>
      </div>
    `;

    document.body.appendChild(toast);
    requestAnimationFrame(() =>
      toast.classList.replace("opacity-0", "opacity-100")
    );
    toast.classList.replace("scale-95", "scale-100");

    return new Promise((resolve) => {
      document.getElementById("toast-cancel").onclick = () => {
        toast.remove();
        overlay.remove();
        resolve(false);
      };
      document.getElementById("toast-confirm").onclick = () => {
        toast.remove();
        overlay.remove();
        resolve(true);
      };
    });
  } else {
    toast.innerHTML = `<p class="text-center text-base">${message}</p>`;
    document.body.appendChild(toast);

    requestAnimationFrame(() =>
      toast.classList.replace("opacity-0", "opacity-100")
    );
    toast.classList.replace("scale-95", "scale-100");

    // Ocultar automáticamente luego de 3 segundos
    setTimeout(() => {
      toast.classList.replace("opacity-100", "opacity-0");
      toast.classList.replace("scale-100", "scale-95");
      setTimeout(() => {
        toast.remove();
        overlay.remove();
      }, 300);
    }, 3000);
  }
}

loadCalendar();
