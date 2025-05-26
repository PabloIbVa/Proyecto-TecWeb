<?php 
    namespace myapi\Read;
    
    use myapi\DataBase;

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Read extends DataBase {

        public function __construct($db, $user = 'root', $pass = 'W0lverine') {
            parent::__construct($db, $user, $pass);
            $this->data = [];
        }

        public function list() {
            $query = "SELECT * FROM insectos WHERE eliminado = 0";
            $result = $this->conexion->query($query);
            
            if ($result) {
                $this->data = [];
                while ($row = $result->fetch_assoc()) {
                    $this->data[] = $row;
                }
                
                if (empty($this->data)) {
                    $this->data = ['error' => 'No se encontraron insectos'];
                }
            } else {
                $this->data = ['error' => $this->conexion->error];
            }
        }
    
        public function search($criteria) {
            $search = $this->conexion->real_escape_string($criteria);
            $query = "SELECT * FROM insectos WHERE 
                      (id = '$search' OR 
                       nombre LIKE '%$search%' OR 
                       familia LIKE '%$search%' OR 
                       nombre_cientifico LIKE '%$search%') 
                      AND eliminado = 0";
            
            $result = $this->conexion->query($query);
            
            if ($result) {
                $this->data = [];
                while ($row = $result->fetch_assoc()) {
                    $this->data[] = $row;
                }
                
                if (empty($this->data)) {
                    $this->data = ['error' => 'No se encontraron resultados'];
                }
            } else {
                $this->data = ['error' => $this->conexion->error];
            }
        }
    
        public function single($id) {
            $query = "SELECT * FROM insectos WHERE id = '$id' AND eliminado = 0";
            $result = $this->conexion->query($query);
            
            if ($result) {
                $this->data = $result->fetch_assoc();
                if (!$this->data) {
                    $this->data = ['error' => 'No se encontró el insecto'];
                }
            } else {
                $this->data = ['error' => $this->conexion->error];
            }
        }

        public function listLibro() {
            $query = "SELECT * FROM libros WHERE eliminado = 0";
            $result = $this->conexion->query($query);
            
            if ($result) {
                $this->data = [];
                while ($row = $result->fetch_assoc()) {
                    $this->data[] = $row;
                }
                
                if (empty($this->data)) {
                    $this->data = ['error' => 'No se encontraron libros'];
                }
            } else {
                $this->data = ['error' => $this->conexion->error];
            }
        }
    
        public function searchLibro($criteria) {
            $search = $this->conexion->real_escape_string($criteria);
            $query = "SELECT * FROM libros WHERE 
                    (id = '$search' OR 
                    nombre LIKE '%$search%') 
                    AND eliminado = 0";
            
            $result = $this->conexion->query($query);
            
            $this->data = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $this->data[] = $row;
                }

                if (empty($this->data)) {
                    $this->data = ['error' => 'No se encontraron resultados'];
                }
            } else {
                $this->data = ['error' => $this->conexion->error];
            }

        }


    
        public function singleLibro($id) {
            $query = "SELECT * FROM libros WHERE id = '$id' AND eliminado = 0";
            $result = $this->conexion->query($query);
            
            if ($result) {
                $this->data = $result->fetch_assoc();
                if (!$this->data) {
                    $this->data = ['error' => 'No se encontró el libro'];
                }
            } else {
                $this->data = ['error' => $this->conexion->error];
            }
        }

        public function latestLibros($limit = 4) {
            $query = "SELECT * FROM libros WHERE eliminado = 0 ORDER BY id DESC LIMIT $limit";
            $result = $this->conexion->query($query);
            
            if ($result) {
                $this->data = [];
                while ($row = $result->fetch_assoc()) {
                    $this->data[] = $row;
                }
            } else {
                $this->data = ['error' => $this->conexion->error];
            }
        }

        public function latestInsectos($limit = 3) {
            $query = "SELECT * FROM insectos WHERE eliminado = 0 ORDER BY id DESC LIMIT $limit";
            $result = $this->conexion->query($query);
            
            if ($result) {
                $this->data = [];
                while ($row = $result->fetch_assoc()) {
                    $this->data[] = $row;
                }
            } else {
                $this->data = ['error' => $this->conexion->error];
            }
        }

    }
?>