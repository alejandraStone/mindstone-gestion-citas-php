async function fetchBookingsCount() {
  try {
    const res = await fetch('/mindStone/app/controllers/get_info_dashboard_controller.php');
    if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);

    const data = await res.json();

    if (!data.success) {
      console.error('Backend error:', data.message, data.error);
      showToast(`Error loading bookings: ${data.message}`);
      return;
    }

    const card = [...document.querySelectorAll('.cards-dashboard')]
      .find(card => card.querySelector('.titulo-card-dashboard')?.textContent.trim() === 'Bookings');

    if (!card) {
      console.warn('Bookings card not found');
      return;
    }

    // Inyectar datos
    const totalSpan = card.querySelector('.total-bookings');
    const growthSpan = card.querySelector('.booking-growth');

    totalSpan.textContent = data.total_reservations_this_month;
    growthSpan.textContent = data.message;

    //growthSpan.textContent = `${data.percentage_growth >= 0 ? '+' : ''}${data.percentage_growth}% this month`;

    // Color verde o rojo según valor
    growthSpan.classList.toggle('text-green-500', data.percentage_growth >= 0);
    growthSpan.classList.toggle('text-red-500', data.percentage_growth < 0);
  } catch (error) {
    console.error('Fetch error:', error);
    showToast('Network error while loading bookings.');
  }
}

function showToast(message) {
  alert(message);
}

document.addEventListener('DOMContentLoaded', fetchBookingsCount);
