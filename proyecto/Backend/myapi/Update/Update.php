<?php namespace myapi\Update;
    
    use myapi\DataBase;

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Update extends DataBase {

        public function __construct($db, $user = 'root', $pass = 'W0lverine') {
            parent::__construct($db, $user, $pass);
            $this->data = [];
        }

        public function edit($id, $insectData) {
            // Sanitizar los datos
            $id = $this->conexion->real_escape_string($id);
            $nombre = $this->conexion->real_escape_string($insectData['nombre']);
            $familia = $this->conexion->real_escape_string($insectData['familia']);
            $nombre_cientifico = $this->conexion->real_escape_string($insectData['nombre_c']);
            $estado = intval($insectData['estado']);
            $descripcion = $this->conexion->real_escape_string($insectData['descripcion']);
            $habitad = $this->conexion->real_escape_string($insectData['habitad']);
            $alimentacion = $this->conexion->real_escape_string($insectData['alimentacion']);
            $longevidad = $this->conexion->real_escape_string($insectData['longevidad']);
            $imagen = $this->conexion->real_escape_string($insectData['imagen']);
        
            // Actualizar el insecto
            $query = "UPDATE insectos SET 
                    nombre='$nombre',
                    familia='$familia', 
                    nombre_cientifico='$nombre_cientifico', 
                    estado=$estado, 
                    descripcion='$descripcion', 
                    habitad='$habitad', 
                    alimentacion='$alimentacion', 
                    longevidad='$longevidad', 
                    imagen='$imagen' 
                    WHERE id='$id'";
            
            
            $result = $this->conexion->query($query);
            $this->data = $result
                ? ['status' => 'success', 'message' => 'Insecto modificado correctamente']
                : ['status' => 'error', 'message' => $this->conexion->error];

        }

        public function editLibro($id, $bookData) {
            // Sanitizar los datos
            $id = $this->conexion->real_escape_string($id);
            $nombre = $this->conexion->real_escape_string($bookData['nombre']);
            $link = $this->conexion->real_escape_string($bookData['link']);
            $img = $this->conexion->real_escape_string($bookData['img']);
        
            // Actualizar el insecto
            $query = "UPDATE libros SET 
                    nombre='$nombre',
                    link='$link',  
                    img='$img' 
                    WHERE id='$id'";
            
            
            $result = $this->conexion->query($query);
            $this->data = $result
                ? ['status' => 'success', 'message' => 'Libro modificado correctamente']
                : ['status' => 'error', 'message' => $this->conexion->error];

        }

        public function editNoticia($id, $noticiaData) {
            // Sanitizar los datos de entrada
            $id = $this->conexion->real_escape_string($id);
            $titulo = $this->conexion->real_escape_string($noticiaData['titulo']);
            $contenido = $this->conexion->real_escape_string($noticiaData['contenido']);
            $fecha_pub = $this->conexion->real_escape_string($noticiaData['fecha_pub']);
            $img = $this->conexion->real_escape_string($noticiaData['img']);

            // Construir la consulta SQL de actualización
            $query = "UPDATE noticias SET 
                        titulo = '$titulo',
                        contenido = '$contenido',
                        fecha_pub = '$fecha_pub',
                        img = '$img'
                    WHERE id = '$id'";

            // Ejecutar la consulta
            $result = $this->conexion->query($query);

            // Devolver el resultado
            $this->data = $result
                ? ['status' => 'success', 'message' => 'Noticia modificada correctamente']
                : ['status' => 'error', 'message' => $this->conexion->error];
        }
    }
?>