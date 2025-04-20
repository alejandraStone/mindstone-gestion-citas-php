// /mindStone/public/js/add_class.js

// Cargar los coaches dinámicamente
document.addEventListener("DOMContentLoaded", function () {
    fetch("/mindStone/app/models/getCoach.php")
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById("coach");
            select.innerHTML = '<option value="">--Select a coach--</option>';
            data.forEach(coach => {
                let option = document.createElement("option");
                option.value = coach.id;
                option.textContent = coach.name;
                select.appendChild(option);
            });
        })
        .catch(error => console.error("Error loading coach:", error));

    // Agregar inputs dinámicos de horarios por día
    const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    const container = document.getElementById('days-schedules');

    daysOfWeek.forEach(day => {
        const dayDiv = document.createElement('div');
        dayDiv.className = 'day-container';

        dayDiv.innerHTML = `
            <label>
                <input type="checkbox" name="days[${day}][enabled]" value="1">
                ${day}
            </label>
            <div id="times-${day}" style="margin-left: 20px; display: none;">
                <button type="button" onclick="addTime('${day}')">+ Add Time</button>
                <div class="time-inputs"></div>
            </div>
        `;

        container.appendChild(dayDiv);
    });

    // Mostrar horarios si se marca el día
    document.addEventListener('change', function (e) {
        if (e.target.type === 'checkbox' && e.target.name.includes('[enabled]')) {
            const day = e.target.name.match(/days\[(\w+)\]/)[1];
            const scheduleDiv = document.getElementById(`times-${day}`);
            scheduleDiv.style.display = e.target.checked ? 'block' : 'none';
        }
    });
});

function addTime(day) {
    const timeInputsDiv = document.querySelector(`#times-${day} .time-inputs`);
    const input = document.createElement('input');
    input.type = 'time';
    input.name = `days[${day}][times][]`;
    input.required = true;
    timeInputsDiv.appendChild(input);
}
