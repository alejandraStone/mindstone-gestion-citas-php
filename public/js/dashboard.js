/*
Archvio que muestra el menú móvil desplegable de izq a der en el panel de administración
*/
document.addEventListener("DOMContentLoaded", function () {
  /*menu-hamburguesa*/
  toggleMobileMenu();
});

//Función que muestra el menú móvil desplegable de izq a der
function toggleMobileMenu() {
  const mobileMenuButton = document.querySelector(".mobile-menu-button");
  const sidebar = document.querySelector(".sidebar");

  mobileMenuButton.addEventListener("click", () => {
      console.log('Hamburguesa clicada');//para depura
    sidebar.classList.toggle("translate-x-0");
    sidebar.classList.toggle("-translate-x-full");
    document.body.style.overflow = sidebar.classList.contains("translate-x-0")
      ? "hidden"
      : "";
  });
}
