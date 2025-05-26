$(document).ready(function () {
  // Cargar últimos libros
  $.getJSON("Backend/latest-books", function (libros) {
    let html = "";
    if (Array.isArray(libros) && libros.length > 0) {
      for (let i = 0; i < libros.length; i += 2) {
        html += `
          <div class="carousel-item ${i === 0 ? "active" : ""}">
            <div class="d-flex justify-content-center">`;

        for (let j = i; j < i + 2 && j < libros.length; j++) {
          // Usamos la ruta completa si img solo contiene el nombre del archivo
          html += `
            <a href="${libros[j].link}" target="_blank">
            <img src="${libros[j].img}" 
                class="book-img mr-3" 
                 alt="${libros[j].nombre}">
            </a>`;
        }

        html += `</div></div>`;
      }
    } else {
      html = `
        <div class="carousel-item active">
          <p class="text-center text-light">No hay libros disponibles.</p>
        </div>`;
    }

    $("#librosCarousel .carousel-inner").html(html);
  });

  // Cargar últimos insectos
  $.getJSON("Backend/latest-insects", function (insectos) {
    let html = "";
    if (Array.isArray(insectos) && insectos.length > 0) {
      insectos.forEach((insecto, idx) => {
        html += `
          <div class="col-md-4">
            <div class="card">
              <img src="${insecto.imagen || 'Backend/img/placeholder.jpg'}" class="fixed-img" alt="${insecto.nombre}">
              <div class="card-body">
                <h5 class="card-title text-light">${insecto.nombre}</h5>
              </div>
            </div>
          </div>`;
      });
    } else {
      html = `<div class="col"><p class="text-center text-light">No hay insectos disponibles.</p></div>`;
    }

    $("#insectosRecientes").html(html);
  });
});
