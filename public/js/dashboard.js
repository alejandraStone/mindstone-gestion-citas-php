document.addEventListener("DOMContentLoaded", function () {
  /*menu-hamburguesa*/
  toggleMobileMenu();
});

//Función que muestra el menú móvil desplegable de izq a der
function toggleMobileMenu() {
  const mobileMenuButton = document.querySelector(".mobile-menu-button");
  const sidebar = document.querySelector(".sidebar");

  mobileMenuButton.addEventListener("click", () => {
      console.log('Hamburguesa clicada');

    sidebar.classList.toggle("translate-x-0");
    sidebar.classList.toggle("-translate-x-full");
    document.body.style.overflow = sidebar.classList.contains("translate-x-0")
      ? "hidden"
      : "";
  });
}
