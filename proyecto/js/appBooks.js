let edit = false;

//Funcion de busqueda de productos
$(document).ready(function(){
    $('#product-result').hide();
    let edit = false;

    // Función para buscar libros
    $('#search').keyup(function () {
        let search = $('#search').val().trim();

        if (search !== '') {
            $.ajax({
                url: 'http://localhost/Proyecto-TecWeb/proyecto/Backend/books/' + encodeURIComponent(search),
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    let template_table = '';

                    // Manejo de error desde el backend
                    if (response.error) {
                        template_table = `
                            <tr>
                                <td colspan="4" class="text-center text-danger">${response.error}</td>
                            </tr>
                        `;
                        $('#books').html(template_table);
                        $('#product-result').show();
                        return;
                    }

                    // Convertir a array si es un solo objeto
                    let books = Array.isArray(response)
                        ? response
                        : (response && response.id ? [response] : []);

                    if (books.length > 0) {
                        books.forEach(book => {
                            let descripcion = `
                                <li>Link: ${book.link}</li>
                                <li>Imagen: ${book.img}</li>
                            `;

                            template_table += `
                                <tr bookId="${book.id}">
                                    <td>${book.id}</td>
                                    <td>${book.nombre}</td>
                                    <td><ul>${descripcion}</ul></td>
                                    <td>
                                        <button class="book-delete btn btn-danger btn-sm rounded-pill mb-1 btn-block">
                                            Eliminar
                                        </button>
                                        <button class="book-edit btn btn-info btn-sm rounded-pill btn-block">
                                            Editar
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        template_table = `
                            <tr>
                                <td colspan="4" class="text-center text-warning">No se encontraron libros.</td>
                            </tr>
                        `;
                    }

                    $('#books').html(template_table);
                    $('#product-result').show();
                },
                error: function (xhr, status, error) {
                    console.error("Error en la búsqueda:", error);
                    $('#books').html(`
                        <tr>
                            <td colspan="4" class="text-center text-danger">
                                Error al procesar la búsqueda.
                            </td>
                        </tr>
                    `);
                    $('#product-result').show();
                }
            });
        } else {
            // Si el campo está vacío, cargar todos los libros
            fetchBooks();
            $('#product-result').hide();
        }
    });


    // Manejar el envío del formulario
    $('#book-form').submit(function(e) {
        e.preventDefault();
        
        let id = $('#productId').val();
        let bookData = {
            nombre: $('#name').val(),
            link: $('#link').val(),
            img: $('#imagen').val()
        };

        if (edit) {
            bookData.id = id;
        }

        // Validaciones
        let errores = [];
        if (!bookData.nombre) errores.push("El nombre es requerido");
        if (!bookData.link) errores.push("El link al libro es requerido");

        if (errores.length > 0) {
            alert("Errores en el formulario:\n\n" + errores.join("\n"));
            return;
        }

        // Envío AJAX
        let url = 'http://localhost/Proyecto-TecWeb/proyecto/Backend/books';
        let method = edit ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            type: method,
            contentType: 'application/json; charset=UTF-8',
            dataType: 'json',
            data: JSON.stringify(bookData),
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                
                let template_bar = `
                    <li style="list-style: none;">status: ${response.status}</li>
                    <li style="list-style: none;">message: ${response.message}</li>
                `;
                $("#product-result").addClass("card my-4 d-block");
                $("#container").html(template_bar);
                
                // Limpiar formulario
                if (!edit) {
                    $('#book-form')[0].reset();
                    $('#imagen').val('Backend/img/insect/default.png');
                }
                
                setTimeout(() => {
                    fetchBooks();
                    edit = false;
                    $('button.btn-primary').text("Agregar Libro");
                }, 1000);
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", xhr.responseText || error);
                alert("Error al " + (edit ? "actualizar" : "crear") + " el libro");
            }
        });
    });

    // Función para cargar todos los libros
    function fetchBooks() {
        $.get("http://localhost/Proyecto-TecWeb/proyecto/Backend/books", function(data) {
            console.log("Respuesta del servidor:", data);
            
            try {
                let libros = typeof data === 'string' ? JSON.parse(data) : data;
                let template = "";
                
                libros.forEach(libro => {
                    let descripcion = `
                        <li>Link: ${libro.link}</li>
                        <li>Imagen: ${libro.img}</li>
                    `;
                    
                    template += `
                        <tr bookId="${libro.id}">
                            <td>${libro.id}</td>
                            <td>${libro.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="book-delete btn btn-danger btn-sm rounded-pill mb-1 btn-block">
                                    Eliminar
                                </button>
                                <button class="book-edit btn btn-info btn-sm rounded-pill btn-block">
                                    Editar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                $("#books").html(template);
            } catch (error) {
                console.error("Error al procesar los libros:", error);
                $("#books").html('<tr><td colspan="4">Error al cargar los libros</td></tr>');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            $("#books").html('<tr><td colspan="4">No se pudieron cargar los libros</td></tr>');
        });
    }

    // Eliminar un insecto
    $(document).on('click', '.book-delete', function() {
        if (confirm('¿Estás seguro de eliminar este insecto?')) {
            let element = $(this).closest('tr');
            let id = $(element).attr('bookId');
            
            $.ajax({
                url: 'http://localhost/Proyecto-TecWeb/proyecto/Backend/books',
                type: 'DELETE',
                data: JSON.stringify({ id: id }),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response && response.status === 'success') {
                        fetchBooks();
                        alert('Libro eliminado correctamente');
                    } else {
                        alert('Error al eliminar: ' + (response?.message || 'Respuesta inválida'));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la conexión: ' + error);
                    console.error("Detalles del error:", xhr.responseText);
                }
            });
        }
    });

    // Editar un libro
    $(document).on('click', '.book-edit', function() {
        let element = $(this).closest('tr');
        let id = $(element).attr('bookId');
        $('button.btn-primary').text("Modificar Libro");
        
        $.ajax({
            url: 'http://localhost/Proyecto-TecWeb/proyecto/Backend/books/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(book) {
    // Si es un array, tomar el primer elemento
                let libro = Array.isArray(book) ? book[0] : book;

                if (libro && Object.keys(libro).length > 0 && !libro.error) {
                    $('#name').val(libro.nombre);
                    $('#link').val(libro.link);
                    $('#imagen').val(libro.img);
                    $('#productId').val(libro.id);
                    edit = true;
                } else {
                    alert("Libro no encontrado");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener el libro:", error);
                alert("Ocurrió un error al cargar el libro");
            } 
        });
    });

    // Cargar insectos al iniciar
    fetchBooks();
});