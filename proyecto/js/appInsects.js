let edit = false;

function init() {
    fetchInsects();
}

//Funcion de busqueda de productos
$(document).ready(function(){
    $('#product-result').hide();
    let edit = false;

    // Función para buscar insectos
    $('#search').keyup(function () {
        let search = $('#search').val().trim();

        if (search !== '') {
            $.ajax({
            url: 'http://localhost/Proyecto-TecWeb/proyecto/Backend/insects/' + encodeURIComponent(search),
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
                $('#insects').html(template_table);
                $('#product-result').show();
                return;
                }

                // Convertir a array si es un solo objeto
                let insects = Array.isArray(response)
                ? response
                : (response && response.id ? [response] : []);

                if (insects.length > 0) {
                insects.forEach(insect => {
                    let descripcion = `
                    <li>Familia: ${insect.familia}</li>
                    <li>Nombre científico: ${insect.nombre_cientifico}</li>
                    <li>Estado: ${getEstadoText(insect.estado)}</li>
                    <li>Hábitat: ${insect.habitad}</li>
                    <li>Alimentación: ${insect.alimentacion}</li>
                    <li>Longevidad: ${insect.longevidad}</li>
                    `;

                    template_table += `
                    <tr insectId="${insect.id}">
                        <td>${insect.id}</td>
                        <td>${insect.nombre}</td>
                        <td><ul>${descripcion}</ul></td>
                        <td>
                        <button class="insect-delete btn btn-danger btn-sm rounded-pill mb-1 btn-block">
                            Eliminar
                        </button>
                        <button class="insect-edit btn btn-info btn-sm rounded-pill btn-block">
                            Editar
                        </button>
                        </td>
                    </tr>
                    `;
                });
                } else {
                template_table = `
                    <tr>
                    <td colspan="4" class="text-center text-warning">No se encontraron insectos.</td>
                    </tr>
                `;
                }

                $('#insects').html(template_table);
                $('#product-result').show();
            },
            error: function (xhr, status, error) {
                console.error("Error en la búsqueda:", error);
                $('#insects').html(`
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
            fetchInsects();
            $('#product-result').hide();
        }
    });


    // Función para traducir el estado numérico a texto
    function getEstadoText(estado) {
        const estados = {
            0: "Data deficiente",
            1: "Extinta",
            2: "Extinta en estado silvestre",
            3: "En peligro crítico de extinción",
            4: "En peligro de extinción",
            5: "Vulnerable",
            6: "Casi amenazada",
            7: "Preocupación menor"
        };
        return estados[estado] || "Desconocido";
    }

    // Manejar el envío del formulario
    $('#insect-form').submit(function(e) {
        e.preventDefault();
        
        let id = $('#productId').val();
        let insectData = {
            nombre: $('#name').val(),
            familia: $('#familia').val(),
            nombre_c: $('#nombre_c').val(),
            estado: $('#estado').val(),
            descripcion: $('#descripcion').val(),
            habitad: $('#habitad').val(),
            alimentacion: $('#alimentacion').val(),
            longevidad: $('#longevidad').val(),
            imagen: $('#imagen').val()
        };

        if (edit) {
            insectData.id = id;
        }

        // Validaciones
        let errores = [];
        if (!insectData.familia) errores.push("La familia es requerida");
        if (!insectData.nombre_c) errores.push("El nombre científico es requerido");
        if (!insectData.descripcion) errores.push("La descripción es requerida");
        if (!insectData.habitad) errores.push("El hábitat es requerido");
        if (!insectData.alimentacion) errores.push("La alimentación es requerida");
        if (!insectData.longevidad) errores.push("La longevidad es requerida");

        if (errores.length > 0) {
            alert("Errores en el formulario:\n\n" + errores.join("\n"));
            return;
        }

        // Envío AJAX
        let url = 'http://localhost/Proyecto-TecWeb/proyecto/Backend/insects';
        let method = edit ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            type: method,
            contentType: 'application/json; charset=UTF-8',
            dataType: 'json',
            data: JSON.stringify(insectData),
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
                    $('#insect-form')[0].reset();
                    $('#imagen').val('Backend/img/insect/default.png');
                }
                
                setTimeout(() => {
                    fetchInsects();
                    edit = false;
                    $('button.btn-primary').text("Agregar Insecto");
                }, 1000);
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", xhr.responseText || error);
                alert("Error al " + (edit ? "actualizar" : "crear") + " el insecto");
            }
        });
    });

    // Función para cargar todos los insectos
    function fetchInsects() {
        $.get("http://localhost/Proyecto-TecWeb/proyecto/Backend/insects", function(data) {
            console.log("Respuesta del servidor:", data);
            
            try {
                let insectos = typeof data === 'string' ? JSON.parse(data) : data;
                let template = "";
                
                insectos.forEach(insecto => {
                    let descripcion = `
                        <li>Familia: ${insecto.familia}</li>
                        <li>Nombre científico: ${insecto.nombre_cientifico}</li>
                        <li>Estado: ${getEstadoText(insecto.estado)}</li>
                        <li>Hábitat: ${insecto.habitad}</li>
                        <li>Alimentación: ${insecto.alimentacion}</li>
                        <li>Longevidad: ${insecto.longevidad}</li>
                    `;
                    
                    template += `
                        <tr insectId="${insecto.id}">
                            <td>${insecto.id}</td>
                            <td>${insecto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="insect-delete btn btn-danger btn-sm rounded-pill mb-1 btn-block">
                                    Eliminar
                                </button>
                                <button class="insect-edit btn btn-info btn-sm rounded-pill btn-block">
                                    Editar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                $("#insects").html(template);
            } catch (error) {
                console.error("Error al procesar los insectos:", error);
                $("#insects").html('<tr><td colspan="4">Error al cargar los insectos</td></tr>');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            $("#insects").html('<tr><td colspan="4">No se pudieron cargar los insectos</td></tr>');
        });
    }

    // Eliminar un insecto
    $(document).on('click', '.insect-delete', function() {
        if (confirm('¿Estás seguro de eliminar este insecto?')) {
            let element = $(this).closest('tr');
            let id = $(element).attr('insectId');
            
            $.ajax({
                url: 'http://localhost/Proyecto-TecWeb/proyecto/Backend/insects',
                type: 'DELETE',
                data: JSON.stringify({ id: id }),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response && response.status === 'success') {
                        fetchInsects();
                        alert('Insecto eliminado correctamente');
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

    // Editar un insecto
    $(document).on('click', '.insect-edit', function() {
        let element = $(this).closest('tr');
        let id = $(element).attr('insectId');
        $('button.btn-primary').text("Modificar Insecto");
        
        $.ajax({
            url: 'http://localhost/Proyecto-TecWeb/proyecto/Backend/insects/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(insect) {
                if (insect && Object.keys(insect).length > 0) {
                    $('#name').val(insect.nombre);
                    $('#familia').val(insect.familia);
                    $('#nombre_c').val(insect.nombre_cientifico);
                    $('#estado').val(insect.estado);
                    $('#descripcion').val(insect.descripcion);
                    $('#habitad').val(insect.habitad);
                    $('#alimentacion').val(insect.alimentacion);
                    $('#longevidad').val(insect.longevidad);
                    $('#imagen').val(insect.imagen);
                    $('#productId').val(insect.id);
                    
                    edit = true;
                } else {
                    alert("Insecto no encontrado");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener el insecto:", error);
                alert("Ocurrió un error al cargar el insecto");
            } 
        });
    });

    // Cargar insectos al iniciar
    fetchInsects();
});