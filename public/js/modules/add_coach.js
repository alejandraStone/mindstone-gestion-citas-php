document.getElementById('add-coach-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe de manera tradicional

    let formData = new FormData(this); // Recoge los datos del formulario
    
    fetch('/mindStone/app/controllers/add_coach_controller.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Muestra el mensaje de éxito o error según la respuesta del servidor
        const messageElement = document.getElementById('form-message');
        if (data.success) {
            messageElement.textContent = 'Coach added successfully!';
            messageElement.style.color = 'green';
        } else {
            messageElement.textContent = 'An error occurred. Please try again.';
            messageElement.style.color = 'red';
        }
    })
    .catch(error => {
        // Si hay un error en la solicitud, muestra un mensaje de error
        const messageElement = document.getElementById('form-message');
        messageElement.textContent = 'Error: ' + error;
        messageElement.style.color = 'red';
    });
});
