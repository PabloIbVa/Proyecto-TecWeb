<?php namespace myapi\Delete;
    
    use myapi\DataBase;

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Delete extends DataBase {

        public function __construct($db, $user = 'root', $pass = 'W0lverine') {
            parent::__construct($db, $user, $pass);
            $this->data = [];
        }

        public function delete($id) {
            $query = "UPDATE insectos SET eliminado=1 WHERE id = '$id'";
            $result = $this->conexion->query($query);
            if ($result) {
                $this->data = ['status' => 'success', 'message' => 'Insecto eliminado correctamente'];
            } else {
                $this->data = ['status' => 'error', 'message' => $this->conexion->error];
            }
        }

        public function deleteLibro($id) {
            $query = "UPDATE libros SET eliminado=1 WHERE id = '$id'";
            $result = $this->conexion->query($query);
            if ($result) {
                $this->data = ['status' => 'success', 'message' => 'Libro eliminado correctamente'];
            } else {
                $this->data = ['status' => 'error', 'message' => $this->conexion->error];
            }
        }

        public function deleteNoticia($id) {
            $query = "UPDATE noticias SET eliminado=1 WHERE id = '$id'";
            $result = $this->conexion->query($query);
            if ($result) {
                $this->data = ['status' => 'success', 'message' => 'Noticia eliminada correctamente'];
            } else {
                $this->data = ['status' => 'error', 'message' => $this->conexion->error];
            }
        }
    }
?>