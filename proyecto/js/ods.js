$(document).ready(function () {
  $(".tab-link").click(function (e) {
    e.preventDefault();

    const target = $(this).attr("href");

    // Oculta el contenido actual
    $(".tab-content.active").fadeOut(200, function () {
      // Elimina clase activa, muestra el nuevo contenido
      $(".tab-content").removeClass("active");
      $(target).fadeIn(200).addClass("active");
    });

    // Cambiar la clase activa del tab
    $(".tab-link").removeClass("active-tab").css("color", "#d4edc9");
    $(this).addClass("active-tab").css("color", "#81c784");
  });
});