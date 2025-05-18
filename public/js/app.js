//Funciones globales
document.addEventListener("DOMContentLoaded", function () {
  /*---FUNCIONES PARA EL FRONTEND*/

  /*Inicio*/
  /*animación al cargar la card de inicio*/
  initCardAnimations();
  initHamburguerMenu();
  /*---FUNCIONES PARA EL BACKEND*/
  //initLogin();
});


function initCardAnimations() {
  const elements = document.querySelectorAll(".card-services");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.remove("opacity-0", "translate-y-10");
          entry.target.classList.add("opacity-100", "translate-y-0");
        }
      });
    },
    {
      threshold: 0.1,
    }
  );
  elements.forEach((el) => observer.observe(el));
}

//Función que muestra el menú móvil desplegable al hacer clic
function initHamburguerMenu() {
  const menuButton = document.getElementById("hamburger");
  const menu = document.getElementById("mobileMenu");
  const iconOpen = document.getElementById("icon-open");
  const iconClose = document.getElementById("icon-close");

  let isOpen = false;

  menuButton.addEventListener("click", () => {
    isOpen = !isOpen;

    iconOpen.classList.toggle("hidden");
    iconClose.classList.toggle("hidden");

    if (isOpen) {
      menu.classList.remove("hidden");
      setTimeout(() => {
        menu.classList.remove("opacity-0", "-translate-y-5");
        menu.classList.add("opacity-100", "translate-y-0");
      }, 10);
    } else {
      menu.classList.add("opacity-0", "-translate-y-5");
      menu.classList.remove("opacity-100", "translate-y-0");
      setTimeout(() => {
        menu.classList.add("hidden");
      }, 300);
    }
  });
}
/*función cuando le doy clic al botón login
function initLogin(){
    const loginButton = document.getElementById("menu-login");
    loginButton.addEventListener("click", () => {
      window.location.href = "/mindStone/app/views/auth/login.php";
    });

}
*/
