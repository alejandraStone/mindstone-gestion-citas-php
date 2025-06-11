// Importo la función loadUserCredits para mostrar los créditos y actualizar después de cancelar una reserva
import { loadUserCredits } from '/mindStone/public/js/modules/show_user_credits.js';

document.addEventListener('DOMContentLoaded', () => {
  const tableBody = document.getElementById('reservations-table-body');
  const paginationContainer = document.getElementById('pagination-controls');

  let currentPage = 1;// Página actual, se inicializa en 1
  const limit = 4; // Se ajusta el límite de páginas a mostrar en pantalla

  async function loadReservations(page = 1) {
    const offset = (page - 1) * limit;

    try {
      const response = await fetch(`/mindStone/app/controllers/user/get_user_reservations_controller.php?limit=${limit}&offset=${offset}`);
      const data = await response.json();

      if (!data.success) {
        tableBody.innerHTML = `<tr><td class="px-4 py-3 text-red-600">${data.message}</td></tr>`;
        paginationContainer.innerHTML = '';
        return;
      }

      const reservations = data.data;
      const total = data.total || 0;

      if (reservations.length === 0) {
        tableBody.innerHTML = `<tr><td class="px-4 py-3">No reservations yet.</td></tr>`;
        paginationContainer.innerHTML = '';
        return;
      }

      const rows = reservations.map((res) => {
        const timePart = res.hour ? res.hour.slice(0, 5) : '00:00';
        const datetimeString = `${res.instance_date}T${timePart}`;
        const date = new Date(datetimeString);
        const reservedAt = res.reserved_at ? new Date(res.reserved_at) : null;

        const formattedDate = !isNaN(date.getTime())
          ? date.toLocaleDateString('es-ES')
          : 'Invalid date';

        const formattedTime = !isNaN(date.getTime())
          ? date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' })
          : 'Invalid hour';

        const formattedReservedAt = reservedAt && !isNaN(reservedAt.getTime())
          ? reservedAt.toLocaleString('es-ES', {
              day: '2-digit',
              month: '2-digit',
              year: 'numeric',
              hour: '2-digit',
              minute: '2-digit'
            })
          : '-';

        const statusText = res.is_cancelled ? 'Cancelled' : 'Active';
        const statusClasses = res.is_cancelled ? 'text-red-600 font-bold' : 'text-green-600 font-semibold';

        return `
          <tr class="hover:bg-brand-100 transition-colors duration-200">
            <td class="px-4 py-3 font-semibold">${res.pilates_type}</td>
            <td class="px-4 py-3">${res.coach_name}</td>
            <td class="px-4 py-3">${formattedDate}</td>
            <td class="px-4 py-3">${formattedTime}</td>
            <td class="px-4 py-3">${formattedReservedAt}</td>
            <td class="px-4 py-3 ${statusClasses}">${statusText}</td>
            <td class="px-4 py-3">
              ${res.is_cancelled ? '' : `
                <button class="border border-red-100 text-brand-900 bg-white rounded px-3 py-1 text-xs hover:bg-red-100 cancel-reservation-btn" data-id="${res.reservation_id}">
                  Cancel
                </button>`}
            </td>
          </tr>`;
      }).join('');

      tableBody.innerHTML = rows;
      updatePagination(total, page);
    } catch (err) {
      console.error(err);
      tableBody.innerHTML = `<tr><td class="px-4 py-3 text-red-600">Error loading reservations.</td></tr>`;
      paginationContainer.innerHTML = '';
    }
  }

  function updatePagination(totalItems, currentPage) {
    const totalPages = Math.ceil(totalItems / limit);
    paginationContainer.innerHTML = '';

    if (totalPages <= 1) return;

    const prevBtn = document.createElement('button');
    prevBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>`;
    prevBtn.className = 'px-3 py-1 rounded bg-brand-400 text-white';
    prevBtn.disabled = currentPage === 1;
    prevBtn.onclick = () => {
      currentPage--;
      loadReservations(currentPage);
    };

    const nextBtn = document.createElement('button');
    nextBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>`;
    nextBtn.className = 'px-3 py-1 rounded bg-brand-400 text-white';
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.onclick = () => {
      currentPage++;
      loadReservations(currentPage);
    };

    const pageInfo = document.createElement('span');
    pageInfo.className = 'mx-4';
    pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;

    paginationContainer.appendChild(prevBtn);
    paginationContainer.appendChild(pageInfo);
    paginationContainer.appendChild(nextBtn);
  }

  // Toast y cancelación de reserva
  async function showToast(message, options = {}) {
    const overlay = document.createElement("div");
    overlay.className = "fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40";

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

      document.body.appendChild(overlay);
      document.body.appendChild(toast);
      requestAnimationFrame(() => {
        toast.classList.replace("opacity-0", "opacity-100");
        toast.classList.replace("scale-95", "scale-100");
      });

      return new Promise((resolve) => {
        document.getElementById("toast-cancel").onclick = () => {
          toast.classList.replace("opacity-100", "opacity-0");
          toast.classList.replace("scale-100", "scale-95");
          setTimeout(() => {
            toast.remove();
            overlay.remove();
            resolve(false);
          }, 300);
        };
        document.getElementById("toast-confirm").onclick = () => {
          toast.classList.replace("opacity-100", "opacity-0");
          toast.classList.replace("scale-100", "scale-95");
          setTimeout(() => {
            toast.remove();
            overlay.remove();
            resolve(true);
          }, 300);
        };
      });
    } else {
      toast.innerHTML = `<p class="text-center text-base">${message}</p>`;
      document.body.appendChild(overlay);
      document.body.appendChild(toast);
      requestAnimationFrame(() => {
        toast.classList.replace("opacity-0", "opacity-100");
        toast.classList.replace("scale-95", "scale-100");
      });
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

  document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('cancel-reservation-btn')) {
      const reservationId = e.target.dataset.id;
      const confirmed = await showToast('Are you sure you want to cancel this reservation?', { confirm: true });
      if (!confirmed) return;

      try {
        const res = await fetch('/mindStone/app/controllers/user/cancel_reservation_controller.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ reservation_id: reservationId })
        });

        const result = await res.json();
        if (result.success) {
          showToast('Reservation cancelled successfully.');
          await loadReservations(currentPage);
          await loadUserCredits();
        } else {
          showToast(result.message || 'Could not cancel the reservation.');
        }
      } catch (err) {
        console.error(err);
        showToast('Error cancelling reservation.');
      }
    }
  });

  // Inicial
  loadReservations(currentPage);
});
