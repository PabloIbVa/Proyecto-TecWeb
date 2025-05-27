<?php

  require_once __DIR__ . "/vendor/autoload.php";

  use myapi\Auth\UserAuth;

  session_start();

  if (isset($_SESSION["user_id"])) {
      $auth = new UserAuth('bugweb');
      $user = $auth->getUserById($_SESSION["user_id"]);
  }
  
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Añadir Noticias</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/add_news.css">
  </head>
  <body onclick="closeMenu(event)">
    <header class="d-flex justify-content-between align-items-center p-3 animated-header">
      <div class="d-flex align-items-center">
        <img src="Backend/img/logo/lotus-with-hands-1889661_1280.png" alt="Logo" class="logo me-2">
        <h3 class="m-0">BugWeb</h3>
      </div>
      <form class="form-inline my-2 my-lg-0 ml-auto mr-3" style="max-width: 350px; min-width: 250px;">
        <input class="form-control mr-sm-2" name="search" id="search" type="search" placeholder="ID,nombre o link" aria-label="Search">
        <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
      </form>
      <button class="menu-btn" onclick="toggleMenu()">
        <i class="bi bi-bug-fill"></i>
      </button>
    </header>
  
    <div class="sidebar-menu" id="sidebarMenu">
      <a href="add_news.php">Añadir noticia</a>
      <a href="add_insects.php">Añadir nuevo insecto</a>
      <a href="add_books.php">Añadir libro</a>
      <a href="ods.php">ODS</a>
      <a href="index.php">Ir a página principal</a>

      <hr>

      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-primary">Iniciar sesión</a>
        <a href="signup.html" class="btn btn-secondary">Registrarse</a>
      <?php endif; ?>
    </div>


    <div class="container">
      <div class="row p-4">
        <div class="col-md-5">
          <div class="card">
            <div class="card-body">
              <!-- FORMULARIO PARA AGREGAR PRODUCTO -->
              <form id="new-form">
                <div class="form-group">
                  <label for="titulo">Titulo de la noticia:</label>
                  <input class="form-control" type="text" id="titulo" placeholder="Titulo de la noticia" required>
                </div>
                <div class="form-group">
                  <fieldset>
                    <label for="fecha_pub">Fecha de publicación:</label>
                    <input type="date" id="fecha_pub" name="fecha_pub" class="form-control" required>
          
                    <br><label for="contenido">Contenido:</label>
                    <input type="textarea" id="contenido" name="contenido" class="form-control" required>
          
                    <label for="form-image">Imagen:</label> 
                    <input type="text" id="img" name="img" class="form-control" required value="Backend/img/noticias/default.jpg">
                  </fieldset>
                </div>
                <input type="hidden" id="productId">
                <button class="btn btn-primary btn-block text-center" type="submit">
                  Agregar Noticia
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- TABLA  -->
        <div class="col-md-7">
          <div class="card my-4 d-none" id="product-result">
            <div class="card-body">
              <!-- RESULTADO -->
              <ul id="container"></ul>
            </div>
          </div>

          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <td>Id</td>
                <td>Titulo</td>
                <td>Descripción</td>
              </tr>
            </thead>
            <tbody id="news"></tbody>
          </table>
        </div>
      </div>
    </div>
    <footer class="p-4">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <h5>BugWeb</h5>
          </div>
          <div class="col-md-3">
            <h6>Integrantes</h6>
            <p>Pablo Ivan Ibarra Valencia</p>
            <p>Bernardo Palacios Caballero</p>
            <p>Rodrigo Robledo Ordoñez</p>
          </div>
          <div class="col-md-3">
            <h6>Materia</h6>
            <p>Tecnologías Web</p>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
    <!-- Lógica del Frontend -->
    <script src="js/appNews.js"></script>
    <script>
      function toggleMenu() {
        const menu = document.getElementById('sidebarMenu');
        menu.classList.toggle('show');
      }
      function closeMenu(event) {
        const menu = document.getElementById('sidebarMenu');
        const button = document.querySelector('.menu-btn');
        if (!menu.contains(event.target) && !button.contains(event.target)) {
          menu.classList.remove('show');
        }
      }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  
  </body>
</html>