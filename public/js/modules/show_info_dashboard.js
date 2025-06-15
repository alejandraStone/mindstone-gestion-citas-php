/*
 Este archivo contiene el código para mostrar informacion del numero de reservas, clases más y menos populares, horas pico, usuarios registrados y visitas al sitio web en el dashboard.
 Este código se ejecuta al cargar la página y obtiene los datos del backend a través de una solicitud fetch.
 Se usa la API de google analytics para obtener el número de viisitas al sitio web.
 */

//funcioón que se ejecuta al cargar la página para obtener el número de reservas y mostrarlo en el dashboard.
async function fetchBookingsCount() {
  try {
    const res = await fetch(
      "/mindStone/app/controllers/get_info_dashboard_controller.php"
    );
    if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);

    const data = await res.json();
    console.log("Dashboard data:", data); // Para depurar, muestra los datos obtenidos en la consola
    // Verifica si la respuesta contiene un error
    if (!data.success) {
      console.error("Backend error:", data.message, data.error);
      showToast(`Error loading bookings: ${data.message}`);
      return;
    }

    // --- Card de Bookings ---
    const bookingsCard = [
      ...document.querySelectorAll(".cards-dashboard"),
    ].find(
      (card) =>
        card.querySelector(".titulo-card-dashboard")?.textContent.trim() ===
        "Bookings"
    );

    if (bookingsCard) {
      const totalSpan = bookingsCard.querySelector(".total-bookings");
      const growthSpan = bookingsCard.querySelector(".booking-growth");
      if (totalSpan) totalSpan.textContent = data.total_reservations_this_month;
      if (growthSpan) {
        // Muestra +x% o -x%
        if (typeof data.growth_percentage === "number") {
          const percent = Math.abs(data.growth_percentage);
          const isPositive = data.growth_percentage >= 0;
          growthSpan.textContent =
            (isPositive ? "+" : "-") + percent + "% this month";
          growthSpan.classList.toggle("text-green-500", isPositive);
          growthSpan.classList.toggle("text-red-500", !isPositive);
        } else {
          growthSpan.textContent = "No data last month";
          growthSpan.classList.remove("text-green-500", "text-red-500");
        }
      }
    } else {
      console.warn("Bookings card not found");
    }

    // --- Card de Clase más popular ---
    const popularClassCard = [
      ...document.querySelectorAll(".cards-dashboard"),
    ].find(
      (card) =>
        card.querySelector(".titulo-card-dashboard")?.textContent.trim() ===
        "Most popular class"
    );
    if (popularClassCard) {
      const classSpan = popularClassCard.querySelector(".most-popular-class");
      if (classSpan) {
        classSpan.textContent =
          data.most_popular_class || "No bookings this month";
      }
    } else {
      console.warn("Most popular class card not found");
    }

    // --- Card de Clase menos popular ---
    const lowOccCard = [...document.querySelectorAll(".cards-dashboard")].find(
      (card) =>
        card.querySelector(".titulo-card-dashboard")?.textContent.trim() ===
        "Least popular class"
    );
    if (lowOccCard) {
      const lowOccSpan = lowOccCard.querySelector(".least-popular-class");
      if (lowOccSpan) {
        lowOccSpan.textContent =
          data.least_popular_class || "No bookings this month";
      }
    } else {
      console.warn("Classes with low occupancy card not found");
    }

    // --- Card de Peak hours---
    const peakCard = [...document.querySelectorAll(".cards-dashboard")].find(
      (card) =>
        card
          .querySelector(".titulo-card-dashboard")
          ?.textContent.trim()
          .toLowerCase() === "peak hours"
    );
    if (peakCard) {
      const hourSpan = peakCard.querySelector(".peak-hour-booking");
      const growthSpan = peakCard.querySelector(".peak-hour-growth");
      if (hourSpan && typeof data.peak_hour === "number") {
        hourSpan.textContent =
          data.peak_hour.toString().padStart(2, "0") + ":00";
      } else if (hourSpan) {
        hourSpan.textContent = "No data";
      }
      if (growthSpan) {
        if (typeof data.peak_hour_growth === "number") {
          const percent = Math.abs(data.peak_hour_growth);
          const isPositive = data.peak_hour_growth >= 0;
          growthSpan.textContent =
            (isPositive ? "+" : "-") + percent + "% this month";
          growthSpan.classList.toggle("text-green-500", isPositive);
          growthSpan.classList.toggle("text-red-500", !isPositive);
        } else {
          growthSpan.textContent = "No data last month";
          growthSpan.classList.remove("text-green-500", "text-red-500");
        }
      }
    }
    // --- Card de Users ---
    const usersCard = [...document.querySelectorAll(".cards-dashboard")].find(
      (card) =>
        card
          .querySelector(".titulo-card-dashboard")
          ?.textContent.trim()
          .toLowerCase() === "registered users"
    );

if (usersCard) {
  const usersThisMonthSpan = usersCard.querySelector('.registered-users'); // span para usuarios registrados este mes
  const usersGrowthSpan = usersCard.querySelector('.users-growth');// span para crecimiento de usuarios

  const actual = data.registered_users_this_month;
  const previous = data.registered_users_last_month;
  const growth = data.registered_users_growth_percentage;
  const diff = actual - previous;
  const isPositive = diff >= 0;// Verifica si el crecimiento es positivo o negativo

    // Mostrar cantidad de usuarios este mes
    if (usersThisMonthSpan) {
      usersThisMonthSpan.textContent = typeof actual === 'number' ? actual : '—';
    }
  //mostrar el crecimiento de usuarios
  if (usersGrowthSpan) {
    if (previous === 0 && actual > 0) {
      // Mes anterior 0, este mes > 0
      usersGrowthSpan.innerHTML = `
        <span class="text-green-500 mr-1">+${diff} users (New!)</span>
        <span class="text-gray-500 ml-1">vs last month</span>
      `;
    } else if (typeof growth === "number") {
      usersGrowthSpan.innerHTML = `
        <span class="${isPositive ? "text-green-500" : "text-red-500"} mr-1">
          ${isPositive ? "+" : ""}${diff} users (${isPositive ? "+" : "-"}${Math.abs(growth).toFixed(0)}%)
        </span>
        <span class="text-gray-500 ml-1">vs last month</span>
      `;
    } else {
      usersGrowthSpan.textContent = "No data last month";
      usersGrowthSpan.classList.remove("text-green-500", "text-red-500");
    }
  }
  }

  // --- Card de Views (Website) ---
const viewsCard = [...document.querySelectorAll('.cards-dashboard')].find(
  card =>
    card.querySelector('.titulo-card-dashboard')?.textContent.trim().toLowerCase() === 'views to the website'
);

if (viewsCard) {
  const websiteViewsSpan = viewsCard.querySelector('.website-views');
  const websiteViewsGrowthSpan = viewsCard.querySelector('.website-views-growth');

  const actualViews = data.website_views_this_month;
  const growthViews = data.website_views_growth_percentage;

  // Mostrar cantidad de visitas este mes
  if (websiteViewsSpan) {
    websiteViewsSpan.textContent = typeof actualViews === 'number' ? actualViews : '—';
  }

  // Mostrar crecimiento de visitas (solo porcentaje)
  if (websiteViewsGrowthSpan) {
    if (typeof growthViews === "number") {
      const isPositive = growthViews >= 0;
      websiteViewsGrowthSpan.innerHTML = `
        <span class="${isPositive ? 'text-green-500' : 'text-red-500'} mr-1">
          ${isPositive ? '+' : '-'}${Math.abs(growthViews).toFixed(0)}%
        </span>
        <span class="text-gray-500 ml-1">vs last month</span>
      `;
    } else {
      websiteViewsGrowthSpan.textContent = "No data for last month";
      websiteViewsGrowthSpan.classList.remove("text-green-500", "text-red-500");
    }
  }
}
  } catch (error) {
    console.error("Fetch error:", error);
    showToast("Network error while loading dashboard.");
  }
}

// Función para mostrar un mensaje de alerta al usuario cuando existe un error al cargar los datos.
function showToast(message) {
  alert(message);
}
// Ejecuta la función principal cuando el DOM esté listo.
document.addEventListener("DOMContentLoaded", fetchBookingsCount);
