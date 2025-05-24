document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('add-coach-form');
    if (!form) {
        console.error('No se encontró el formulario con id add-coach-form');
        return;
    }
    form.addEventListener('submit', function(event) {
        event.preventDefault();

    const form = this;
    const messageElement = document.getElementById('form-message');
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) submitButton.disabled = true;

    let formData = new FormData(form);

    fetch('/mindStone/app/controllers/add_coach_controller.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageElement.textContent = data.message;
            messageElement.style.color = 'green';
            form.reset();
            if (coachesVisible) loadCoachesList();// Recargar la lista de coaches si está visible
        } else {
            messageElement.textContent = data.message || 'An error occurred. Please try again.';
            messageElement.style.color = 'red';
        }
    })
    .catch(error => {
        messageElement.textContent = 'Error: ' + error;
        messageElement.style.color = 'red';
    })
    .finally(() => {
        if (submitButton) submitButton.disabled = false;
    });
});

// --- VARIABLES PARA MOSTRAR EL BLOQUE DE TODOS LOS COACHES ---
const toggleCoachBtn = document.getElementById("toggle-coach-list");
const coachListSection = document.getElementById("coach-list-section");
const coachesList = document.getElementById("coaches-list");
let coachesVisible = false;

// --- FUNCIÓN PARA MOSTRAR U OCULTAR EL LISTADO DE COACHES ---
toggleCoachBtn.addEventListener("click", function () {
    coachesVisible = !coachesVisible;
    coachListSection.classList.toggle("hidden", !coachesVisible);
    toggleCoachBtn.textContent = coachesVisible ? "Hide Coaches" : "Show Coaches";
    // Si se va a mostrar, cargar los coaches
    if (coachesVisible) {
        loadCoachesList();
    }
});
// --- FUNCIÓN PARA CARGAR Y MOSTRAR LOS COACHES ---
function loadCoachesList() {
    coachesList.innerHTML = '<div class="text-brand-700 text-center py-4 col-span-full">Loading...</div>';

    fetch('/mindStone/app/controllers/get_coaches_by_speciality_controller.php')
        .then(res => res.json())
        .then(data => {
            if (data.success && Array.isArray(data.coaches) && data.coaches.length > 0) {
                coachesList.innerHTML = data.coaches.map(coach => `
                    <div class="bg-white shadow rounded-xl p-4 flex flex-col gap-2 border border-brand-100">
                        <div class="flex-1">
                            <div class="text-brand-900 font-bold text-lg">${coach.name} ${coach.lastName}</div>
                            <div class="text-brand-700 text-sm">${coach.email}</div>
                            <div class="text-brand-500 text-sm">${coach.phone}</div>
                            ${coach.specialities && coach.specialities.length ? `
                                <div class="flex flex-wrap gap-2 mt-2">
                                    ${coach.specialities.map(sp => {
                                        // Colores según tipo
                                        let color = "bg-brand-100 border-brand-300 text-brand-800";
                                        if(sp === "Full Body") color = "bg-lime-100 border-lime-200 text-lime-800";
                                        else if(sp === "Mat") color = "bg-emerald-100 border-emerald-200 text-emerald-800";
                                        else if(sp === "Reformer") color = "bg-violet-100 border-violet-300 text-violet-800";
                                        return `<span class="text-xs px-2 py-1 rounded-full border ${color}">${sp}</span>`;
                                    }).join('')}
                                </div>
                            ` : ''}
                        </div>
                        <div class="mt-3 flex gap-2">
                            <button class="border-brand-200 text-brand-900 bg-white rounded px-3 py-1 text-xs hover:bg-brand-100">Edit</button>
                            <button class="border border-red-100 text-red-600 bg-white rounded px-3 py-1 text-xs hover:bg-red-100">Delete</button>
                        </div>
                    </div>
                `).join('');
            } else {
                coachesList.innerHTML = '<div class="text-brand-500 text-center py-8 col-span-full">No coaches found.</div>';
            }
        })
        .catch(() => {
            coachesList.innerHTML = '<div class="text-red-500 text-center py-8 col-span-full">Error loading coaches.</div>';
        });
}
});