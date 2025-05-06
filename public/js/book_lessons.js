
// Código JS para mostrar días de la semana
document.addEventListener('DOMContentLoaded', function() {

const daysSchedules = document.getElementById('days-schedules');
const classResults = document.getElementById('class-results');

const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

days.forEach(day => {
    const button = document.createElement('button');
    button.textContent = day;
    button.addEventListener('click', () => loadClassesForDay(day));
    daysSchedules.appendChild(button);
});

function loadClassesForDay(day) {
    fetch('/mindStone/app/controllers/get_lessons_by_day.php?day=' + encodeURIComponent(day))//encodeURIComponent por si el día tiene caracteres raros
    .then(response => response.json())
    .then(data => {
        classResults.innerHTML = ''; // Limpiar resultados anteriores
        if (data.length === 0) {
            classResults.innerHTML = '<p>No classes available for ' + day + '.</p>';
        } else {
            data.forEach(lesson => {
                const div = document.createElement('div');
                div.innerHTML = `
                    <h3>${lesson.pilates_type}</h3>
                    <p>Time: ${lesson.hour}</p>
                    <p>Coach: ${lesson.coach_name}</p>
                    <button class="reserve-btn" data-lesson-id="${lesson.id}">Reserve</button>
                `;
                classResults.appendChild(div);
            });
        }
    })
    .catch(error => {
        console.error('Error fetching classes:', error);
        classResults.innerHTML = '<p>Something went wrong while fetching classes.</p>';
    });
}
});
//fetch desde Js para enviar el ID de la clase y recibir la respuesta.
function reserveClass(lessonId) {
    fetch('/mindStone/app/controllers/reserve_lesson.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ lesson_id: lessonId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Respuesta del servidor:", data); //me muestra la respuesta??
            showConfirmationMessage('¡Clase reservada exitosamente!');
        } else {
            showConfirmationMessage('Error al reservar: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error reservando:', error);
        showConfirmationMessage('Hubo un error al procesar tu reserva.');
    });
}


document.addEventListener('click', function(event) {
    if (event.target.classList.contains('reserve-btn')) {
        const lessonId = event.target.dataset.lessonId;
        console.log('Botón clickeado con ID:', lessonId); // se envía el ID de la clase o lección
        reserveClass(lessonId);
    }
});
//pop up para que aparezca y desaparezca la confirmación de la reserva
function showConfirmationMessage(message) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('confirmation-message');
    messageDiv.textContent = message;

    document.body.appendChild(messageDiv);

    setTimeout(() => {
        messageDiv.remove();
    }, 3000); // El mensaje desaparece después de 3 segundos
}
