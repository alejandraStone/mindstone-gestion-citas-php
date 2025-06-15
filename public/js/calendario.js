/*
Archivo que carga el calendario de clases de pilates y permite reservar clases desde la página de clases si el usuario está logueado y si no, muestra un modal de login.
Este archivo se carga en la página de clases y en la página de timetable del usuario logueado
*/

//map de colores para cada tipo de clase para el calendario
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

// Función para cargar el calendario de clases
async function loadCalendar() {
  //se obtienen todas las clases creadas por el admin
  const res = await fetch("/mindStone/app/controllers/user/get_all_lessons_controller.php");
  const classes = await res.json();

  //se llama al elemento del calendario
  const calendar = document.getElementById("calendar");
  const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

  const timetable = {};
  const hoursSet = new Set();

  classes.forEach((cl) => {
    const hourKey = cl.hour.substring(0, 5);// Extracción HH:MM de la hora
    hoursSet.add(hourKey);

    if (!timetable[cl.day]) timetable[cl.day] = {};
    if (!timetable[cl.day][hourKey]) timetable[cl.day][hourKey] = [];
    timetable[cl.day][hourKey].push(cl);
  });

  const hours = Array.from(hoursSet).sort();//ordeno las horas

  const table = document.createElement("table");//creo la tabla
  table.className = "min-w-full border-collapse text-sm font-normal";

  const thead = document.createElement("thead");
  thead.innerHTML = `
    <tr class="bg-brand-800 text-white uppercase tracking-wide text-center font-normal">
      <th class="p-3 sticky left-0 bg-brand-800 z-10 text-left font-titulo">Time</th>
      ${days.map((day) => `<th class="p-3 border-l border-brand-800">${day}</th>`).join("")}
    </tr>
  `;
  table.appendChild(thead);

  const tbody = document.createElement("tbody");

  hours.forEach((hour) => {
    const tr = document.createElement("tr");
    tr.className = "hover:bg-brand-100";

    const th = document.createElement("th");
    th.className = "p-2 sticky left-0 bg-white/50 backdrop-blur-sm font-titulo text-brand-700";
    th.textContent = hour;
    tr.appendChild(th);

    days.forEach((day) => {
      const td = document.createElement("td");
      td.className = "p-2 border border-brand-200 align-top min-w-[120px]";
      const lessons = timetable[day]?.[hour] || [];

      if (lessons.length === 0) {
        td.innerHTML = '<span class="text-brand-400 italic">-</span>';
      } else {
        lessons.forEach((lesson) => {
          const colorClass = typeColorMap[lesson.pilates_type_name] || typeColorMap.Default;

          const lessonDiv = document.createElement("div");
          lessonDiv.className = `${colorClass} border rounded-md p-2 mb-2 shadow-md transition transform hover:scale-105 hover:shadow-lg cursor-pointer`;
          lessonDiv.setAttribute("data-aos", "fade-up");
          lessonDiv.setAttribute("data-aos-delay", "100");
          lessonDiv.setAttribute("data-class-instance-id", lesson.id);

          lessonDiv.innerHTML = `
            <div class="font-semibold">${lesson.pilates_type_name}</div>
            <div class="text-xs font-normal text-brand-700 mb-1">Coach: ${lesson.coach_name}</div>
            <div class="text-[11px] text-center text-brand-800 bg-white border border-brand-200 rounded px-2 py-0.5 w-fit shadow-sm hover:bg-brand-700 hover:text-white transition">
              Reserve
            </div>
          `;
//obtiene los datos del usuario logueado para saber si está logueado y poder reservar la clase
          const currentUserId = document.querySelector("main")?.dataset.userId || null;

          lessonDiv.addEventListener("click", async () => {
            const classInstanceId = lessonDiv.getAttribute("data-class-instance-id");

            if (!currentUserId) {
              const loginModal = document.getElementById("loginModal");
              if (loginModal) {
                loginModal.classList.remove("hidden");
              } else {
                showToast("Login modal not found.");
              }
              return;
            }

            const confirmed = await showToast("Do you want to reserve this class?", { confirm: true });
            if (!confirmed) return;

            fetch("/mindStone/app/controllers/user/class_reservation_controller.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded",
              },
              body: `class_instance_id=${encodeURIComponent(classInstanceId)}`,
            })
              .then((response) => response.json())
              .then((data) => {
                showToast(data.message);
                if (data.dev_message) console.error("Dev message:", data.dev_message);
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

  calendar.classList.remove("empty");

  if (typeof AOS !== "undefined") {
    AOS.init({ once: true });
  }

//Muestro el número de semana y el año actual antes de mostrar el calendario
const monthDisplay = document.getElementById("monthDisplay");
if (monthDisplay) {
  const today = new Date();

  // Obtener lunes de la semana actual
  function getMonday(date) {
    const d = new Date(date);
    const day = d.getDay();
    const diff = (day === 0 ? -6 : 1) - day;
    d.setDate(d.getDate() + diff);
    return d;
  }

  const monday = getMonday(today);
  const sunday = new Date(monday);
  sunday.setDate(monday.getDate() + 6);

  const formatter = new Intl.DateTimeFormat("en-GB", {
    month: "long",
  });

  const startDay = monday.getDate().toString().padStart(2, "0");
  const endDay = sunday.getDate().toString().padStart(2, "0");
  const startMonth = formatter.format(monday);
  const endMonth = formatter.format(sunday);
  const year = monday.getFullYear();

  let displayText;
  if (startMonth === endMonth) {
    displayText = `Classes from ${startDay}–${endDay} ${startMonth} ${year}`;
  } else {
    displayText = `Classes from ${startDay} ${startMonth} to ${endDay} ${endMonth} ${year}`;
  }

  monthDisplay.textContent = displayText;
}
}
//función para mostrar un toast con un mensaje y opciones de confirmación
function showToast(message, options = {}) {
  const overlay = document.createElement("div");
  overlay.className = "fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40";
  document.body.appendChild(overlay);

  const toast = document.createElement("div");
  toast.className = `
    fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
    bg-white text-gray-900 p-6 rounded-xl shadow-xl border w-80 z-50
    opacity-0 scale-95 transition-all duration-300
  `;

  if (options.confirm) {
    toast.innerHTML = `
      <p class="mb-4 text-center text-lg font-medium">${message}</p>
      <div class="flex justify-center gap-4">
        <button id="toast-cancel" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Cancel</button>
        <button id="toast-confirm" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">Confirm</button>
      </div>
    `;

    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.replace("opacity-0", "opacity-100"));
    toast.classList.replace("scale-95", "scale-100");
//devuelve una promesa que se resuelve cuando se confirma o cancela la reserva de la clase
    return new Promise((resolve) => {
      document.getElementById("toast-cancel").onclick = () => {
        toast.remove();
        overlay.remove();
        resolve(false);
      };
      //devuelve true si se confirma la reserva de la clase
      document.getElementById("toast-confirm").onclick = () => {
        toast.remove();
        overlay.remove();
        resolve(true);
      };
    });
  } else {
    toast.innerHTML = `<p class="text-center text-base">${message}</p>`;
    document.body.appendChild(toast);

    requestAnimationFrame(() => toast.classList.replace("opacity-0", "opacity-100"));
    toast.classList.replace("scale-95", "scale-100");
//desactiva el toast después de 3 segundos
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
