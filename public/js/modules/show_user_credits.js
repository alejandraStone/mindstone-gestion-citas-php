export async function loadUserCredits() {
  const container = document.getElementById('credits-container');

  try {
    const response = await fetch('/mindStone/app/controllers/user/get_user_credits_controller.php');
    const data = await response.json();

    if (!data.success) {
      container.innerHTML = `<p class="text-red-600 font-semibold">Error loading credits: ${data.message}</p>`;
      return;
    }

    // Filtrar créditos que ya no tienen créditos disponibles o que hayan expirado
    const now = new Date();

    const filteredCredits = data.data.filter(credit => {
      const expiresAt = new Date(credit.expires_at);
      const availableCredits = credit.total_credits - credit.used_credits;
      return availableCredits > 0 && now < expiresAt;
    });

    if (filteredCredits.length === 0) {
      container.innerHTML = `
        <div class="rounded-2xl shadow-md p-5 text-center text-gray-700 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200">
          <p class="text-lg font-semibold">No active credits.</p>
          <p class="mt-2 text-sm opacity-70">Please purchase a credit pack to start booking classes.</p>
        </div>
      `;
      return;
    }

    // Mostrar créditos con diseño Tailwind y estructura responsive
    const html = filteredCredits.map(credit => {
      const expiresAt = new Date(credit.expires_at);
      const expiresFormatted = expiresAt.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
      });

      return `
       <div class="bg-gradient-to-r from-brand-100 via-verdeOlivaClaro to-verdeOlivaMasClaro rounded-2xl shadow-md p-4 sm:p-6 flex flex-col gap-4 w-full max-w-md mx-auto text-oliveShade">
         <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center sm:text-left">
           <div>
             <p class="text-[11px] uppercase font-semibold opacity-70 tracking-widest">Total Credits</p>
             <p class="text-xl font-bold break-words">${credit.total_credits}</p>
           </div>
           <div>
             <p class="text-[11px] uppercase font-semibold opacity-70 tracking-widest">Used Credits</p>
             <p class="text-xl font-bold break-words">${credit.used_credits}</p>
           </div>
           <div>
             <p class="text-[11px] uppercase font-semibold opacity-70 tracking-widest">Expires On</p>
             <p class="text-base font-semibold break-words">${expiresFormatted}</p>
           </div>
         </div>
       </div>
      `;
    }).join('');

    container.innerHTML = html;

  } catch (err) {
    container.innerHTML = `<p class="text-red-600 font-semibold">Error fetching credits.</p>`;
    console.error(err);
  }
}

document.addEventListener('DOMContentLoaded', loadUserCredits);
