let edit = false;

$(document).ready(function () {
    $('#product-result').hide();

    // Función de búsqueda de noticias
    $('#search').keyup(function () {
        let search = $('#search').val().trim();

        if (search) {
            $.ajax({
                url: 'http://localhost/Proyecto-TecWeb/proyecto/Backend/news/' + encodeURIComponent(search),
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    let template = '';
                    let template_table = '';

                    if (Array.isArray(response)) {
                        response.forEach(noticia => {
                            template_table += `
                                <tr noticiaId="${noticia.id}">
                                    <td>${noticia.id}</td>
                                    <td>${noticia.titulo}</td>
                                    <td>${noticia.contenido}</td>
                                    <td>
                                        <button class="noticia-delete btn btn-danger btn-sm rounded-pill mb-1 btn-block">
                                            Eliminar
                                        </button>
                                        <button class="noticia-edit btn btn-info btn-sm rounded-pill btn-block">
                                            Editar
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        template_table = '<tr><td colspan="3">No se encontraron noticias</td></tr>';
                    }

                    $('#container').html(template);
                    $('#news').html(template_table);
                    $('#product-result').show();
                },
                error: function (xhr, status, error) {
                    console.error("Error al buscar noticias:", error);
                    $('#news').html('<tr><td colspan="3">Error al buscar noticias</td></tr>');
                }
            });
        } else {
            fetchNoticias();
            $('#product-result').hide();
        }
    });

    // Envío del formulario
    $('#new-form').submit(function (e) {
        e.preventDefault();

        let noticia = {
            titulo: $('#titulo').val(),
            contenido: $('#contenido').val(),
            fecha_pub: $('#fecha_pub').val(),
            img: $('#img').val()
        };

        let id = $('#productId').val();
        if (edit) noticia.id = id;

        // Validaciones simples
        let errores = [];
        if (!noticia.titulo) errores.push("El título es obligatorio.");
        if (!noticia.contenido) errores.push("El contenido es obligatorio.");
        if (!noticia.fecha_pub) errores.push("La fecha de publicación es obligatoria.");
        if (!noticia.img) errores.push("La imagen es obligatoria.");

        if (errores.length > 0) {
            alert("Errores en el formulario:\n\n" + errores.join("\n"));
            return;
        }

        // AJAX
        let url = 'http://localhost/Proyecto-TecWeb/proyecto/Backend/news';
        let method = edit ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            contentType: 'application/json',
            data: JSON.stringify(noticia),
            success: function(response) {
                console.log("Respuesta del servidor:", response);

                let template_bar = `
                    <li style="list-style: none;"><strong>Status:</strong> ${response.status}</li>
                    <li style="list-style: none;"><strong>Mensaje:</strong> ${response.message}</li>
                `;

                // Asegúrate de que #product-result se muestre correctamente
                $('#product-result')
                    .removeClass('d-none') // quita clase que lo oculta
                    .addClass('d-block'); // agrega clase para mostrarlo (si usas Bootstrap)

                $('#container').html(template_bar);

                if (!edit) $('#new-form')[0].reset();
                $('#img').val("img/default.png");

                setTimeout(() => {
                    fetchNoticias();
                    edit = false;
                    $('button.btn-primary').text("Agregar Noticia");
                }, 1000);
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud:", xhr.responseText || error);
                alert("Error al " + (edit ? "modificar" : "agregar") + " la noticia.");
            }
        });
    });

    // Cargar noticias
    function fetchNoticias() {
        $.get('http://localhost/Proyecto-TecWeb/proyecto/Backend/news', function (data) {
            let noticias = typeof data === 'string' ? JSON.parse(data) : data;
            let template = '';

            noticias.forEach(noticia => {
                template += `
                    <tr noticiaId="${noticia.id}">
                        <td>${noticia.id}</td>
                        <td>${noticia.titulo}</td>
                        <td>${noticia.contenido}</td>
                        <td>
                            <button class="noticia-delete btn btn-danger btn-sm rounded-pill mb-1 btn-block">
                                Eliminar
                            </button>
                            <button class="noticia-edit btn btn-info btn-sm rounded-pill btn-block">
                                Editar
                            </button>
                        </td>
                    </tr>
                `;
            });

            $('#news').html(template);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Error al cargar noticias:", textStatus, errorThrown);
            $('#news').html('<tr><td colspan="3">Error al cargar noticias</td></tr>');
        });
    }

    // Eliminar noticia
    $(document).on('click', '.noticia-delete', function () {
        if (confirm('¿Deseas eliminar esta noticia?')) {
            let id = $(this).closest('tr').attr('noticiaId');

            $.ajax({
                url: 'http://localhost/Proyecto-TecWeb/proyecto/Backend/news',
                type: 'DELETE',
                contentType: 'application/json',
                data: JSON.stringify({ id: id }),
                success: function (response) {
                    alert(response.message || "Eliminado");
                    fetchNoticias();
                },
                error: function (xhr) {
                    console.error("Error al eliminar:", xhr.responseText);
                    alert("Error al eliminar la noticia.");
                }
            });
        }
    });

    // Editar noticia
    $(document).on('click', '.noticia-edit', function () {
        let id = $(this).closest('tr').attr('noticiaId');
        $('button.btn-primary').text("Modificar Noticia");

        $.ajax({
            url: 'http://localhost/Proyecto-TecWeb/proyecto/Backend/news/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (noticia) {
                $('#titulo').val(noticia.titulo);
                $('#contenido').val(noticia.contenido);
                $('#fecha_pub').val(noticia.fecha_pub);
                $('#img').val(noticia.img);
                $('#productId').val(noticia.id);
                edit = true;
            },
            error: function (xhr) {
                console.error("Error al obtener la noticia:", xhr.responseText);
                alert("Error al cargar la noticia.");
            }
        });
    });

    // Al cargar la página
    fetchNoticias();
});
