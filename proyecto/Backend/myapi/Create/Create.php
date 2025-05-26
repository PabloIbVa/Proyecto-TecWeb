<?php namespace myapi\Create;
    
    use myapi\DataBase;

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Create extends DataBase {

        public function __construct($db, $user = 'root', $pass = 'W0lverine') {
            parent::__construct($db, $user, $pass);
            $this->data = [];
        }

        public function add($insecto) {
            // Ya es un objeto stdClass, no uses json_decode aquí
        
            $nombre = $this->conexion->real_escape_string($insecto['nombre']);
            $familia = $this->conexion->real_escape_string($insecto['familia']);
            $nombre_cientifico = $this->conexion->real_escape_string($insecto['nombre_c']);
            $estado = intval($insecto['estado']);
            $descripcion = $this->conexion->real_escape_string($insecto['descripcion']);
            $habitad = $this->conexion->real_escape_string($insecto['habitad']);
            $alimentacion = $this->conexion->real_escape_string($insecto['alimentacion']);
            $longevidad = $this->conexion->real_escape_string($insecto['longevidad']);
            $imagen = $this->conexion->real_escape_string($insecto['imagen']);

            $query = "INSERT INTO insectos (nombre, familia, nombre_cientifico, estado, descripcion, habitad, alimentacion, longevidad, imagen) 
                    VALUES ('$nombre', '$familia', '$nombre_cientifico', $estado, '$descripcion', '$habitad', '$alimentacion', '$longevidad', '$imagen')";
        
            $result = $this->conexion->query($query);
            $nuevoId = $this->conexion->insert_id;
        
            $this->data = $result
                ? ['status' => 'success', 'message' => 'Insecto agregado correctamente', 'id' => $nuevoId]
                : ['status' => 'error', 'message' => $this->conexion->error];
        }
        
        public function addLibro($libro) {
            // Ya es un objeto stdClass, no uses json_decode aquí
        
            $nombre = $this->conexion->real_escape_string($libro['nombre']);
            $link = $this->conexion->real_escape_string($libro['link']);
            $img = $this->conexion->real_escape_string($libro['img']);

            $query = "INSERT INTO libros (nombre, link, img) 
                    VALUES ('$nombre', '$link', '$img')";
        
            $result = $this->conexion->query($query);
            $nuevoId = $this->conexion->insert_id;
        
            $this->data = $result
                ? ['status' => 'success', 'message' => 'Libro agregado correctamente', 'id' => $nuevoId]
                : ['status' => 'error', 'message' => $this->conexion->error];
        }

        public function addNoticia($noticia) {
            // Escapar los valores del array asociativo
            $titulo = $this->conexion->real_escape_string($noticia['titulo']);
            $contenido = $this->conexion->real_escape_string($noticia['contenido']);
            $fecha_pub = $this->conexion->real_escape_string($noticia['fecha_pub']);
            $img = $this->conexion->real_escape_string($noticia['img']);

            // Consulta SQL de inserción
            $query = "INSERT INTO noticias (titulo, contenido, fecha_pub, img)
                    VALUES ('$titulo', '$contenido', '$fecha_pub', '$img')";

            // Ejecutar la consulta
            $result = $this->conexion->query($query);
            $nuevoId = $this->conexion->insert_id;

            // Devolver el resultado
            $this->data = $result
                ? ['status' => 'success', 'message' => 'Noticia agregada correctamente', 'id' => $nuevoId]
                : ['status' => 'error', 'message' => $this->conexion->error];
        }
    }
?>