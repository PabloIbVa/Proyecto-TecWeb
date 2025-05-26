$(document).ready(function () {
  // Cargar últimos artículos
  cargarNoticiasRecientes();

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

function cargarNoticiasRecientes() {
  $.getJSON('Backend/latest-news', function (data) {
    var $carousel = $('#newsItemsContainer');
    $carousel.empty();

    if (!Array.isArray(data) || data.length === 0 || data.error) {
      $carousel.append(`
        <div class="carousel-item active">
          <div class="p-3 text-white">No hay noticias disponibles.</div>
        </div>
      `);
      return;
    }

    $.each(data, function (i, noticia) {
      var activeClass = i === 0 ? 'active' : '';
      var imagen = noticia.img ? noticia.img : 'Backend/img/noticias/default.jpg';
      var descripcion = noticia.contenido ? noticia.contenido : 'Sin descripción disponible.';
      
      var item = `
        <div class="carousel-item ${activeClass}">
          <div class="d-flex flex-column flex-md-row bg-dark p-3">
            <img src="${imagen}" class="rounded mr-md-3 mb-3 mb-md-0" width="200" alt="${noticia.titulo}">
            <div>
              <h5 class="text-light">${noticia.titulo}</h5>
              <p class="text-light">${descripcion}</p>
              <small class="text-muted">Fecha: ${noticia.fecha_pub}</small>
            </div>
          </div>
        </div>
      `;
      $carousel.append(item);
    });

    // Reiniciar el carrusel (opcional)
    $('#newsCarousel').carousel(0);
  }).fail(function () {
    $('#newsItemsContainer').html(`
      <div class="carousel-item active">
        <div class="text-danger p-3">Error al cargar noticias.</div>
      </div>
    `);
  });
}
