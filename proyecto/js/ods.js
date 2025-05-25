$(document).ready(function () {
  $(".tab-link").click(function (e) {
    e.preventDefault();

    const target = $(this).attr("href");

    $(".tab-content:visible").fadeOut(200, function () {
      $(target).fadeIn(200);
    });

    $(".tab-link").removeClass("active-tab").css("color", "#d4edc9");
    $(this).addClass("active-tab").css("color", "#81c784");
  });
});
