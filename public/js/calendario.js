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
  const res = await fetch("/mindStone/app/controllers/user/get_all_lessons_controller.php");
  const classes = await res.json();

  const calendar = document.getElementById("calendar");
  const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

  const timetable = {};
  const hoursSet = new Set();
  days.forEach(day => { timetable[day] = {}; });

  classes.forEach(cl => {
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
    <tr class="bg-brand-300 text-brand-50 uppercase tracking-wide text-center font-normal">
      <th class="p-3 sticky left-0 bg-brand-300 z-10 text-left font-titulo">Time</th>
      ${days.map(day => `<th class="p-3 border-l border-brand-400">${day}</th>`).join("")}
    </tr>
  `;
  table.appendChild(thead);

  // Body
  const tbody = document.createElement("tbody");

  hours.forEach(hour => {
    const tr = document.createElement("tr");
    tr.className = "hover:bg-brand-100";

    const th = document.createElement("th");
    th.className = "p-2 sticky left-0 bg-white/50 backdrop-blur-sm font-titulo text-brand-700";
    th.textContent = hour;
    tr.appendChild(th);

    days.forEach(day => {
      const td = document.createElement("td");
      td.className = "p-2 border border-brand-200 align-top min-w-[120px]";
      const lessons = timetable[day][hour] || [];

      if (lessons.length === 0) {
        td.innerHTML = '<span class="text-brand-400 italic">-</span>';
      } else {
        lessons.forEach(lesson => {
          const colorClass = typeColorMap[lesson.pilates_type_name] || typeColorMap.Default;

          const lessonDiv = document.createElement("div");
          lessonDiv.className = `${colorClass} border rounded-md p-2 mb-2 shadow-md transition transform hover:scale-105 hover:shadow-lg cursor-pointer`;
          lessonDiv.setAttribute("data-aos", "fade-up");
          lessonDiv.setAttribute("data-aos-delay", "100");
          lessonDiv.innerHTML = `
            <div class="font-semibold">${lesson.pilates_type_name}</div>
            <div class="text-xs font-normal text-brand-700">Coach: ${lesson.coach_name}</div>
          `;
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
}

loadCalendar();
