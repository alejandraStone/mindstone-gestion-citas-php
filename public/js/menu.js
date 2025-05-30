document.addEventListener("DOMContentLoaded", function () {

      // --- Menú hamburguesa móvil ---
  function initHamburguerMenu() {
    const $menuButton = $("#hamburger");
    const $menu = $("#mobileMenu");
    const $iconOpen = $("#icon-open");
    const $iconClose = $("#icon-close");
    let isOpen = false;

    if ($menuButton.length) {
      $menuButton.on("click", function () {
        isOpen = !isOpen;
        $iconOpen.toggleClass("hidden");
        $iconClose.toggleClass("hidden");
        if (isOpen) {
          $menu.removeClass("hidden");
          setTimeout(function () {
            $menu
              .removeClass("opacity-0 -translate-y-5")
              .addClass("opacity-100 translate-y-0");
          }, 10);
        } else {
          $menu
            .addClass("opacity-0 -translate-y-5")
            .removeClass("opacity-100 translate-y-0");
          setTimeout(function () {
            $menu.addClass("hidden");
          }, 300);
        }
      });
    }
  }
    initHamburguerMenu();
});