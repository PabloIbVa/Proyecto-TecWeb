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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BugWeb</title>
  <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
</head>
<body onclick="closeMenu(event)">
  <header class="d-flex justify-content-between align-items-center p-3 animated-header">
    <div class="d-flex align-items-center">
      <img src="Backend/img/logo/lotus-with-hands-1889661_1280.png" alt="Logo" class="logo me-2">
      <h3 class="m-0">BugWeb</h3>
    </div>
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


  <!-- Carrusel de Insectos -->
  <div id="insectCarousel" class="carousel slide m-4" data-ride="carousel" data-interval="3000" data-pause="hover">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="Backend\img\diapositivas prin\mantis.jpg" class="d-block w-100" alt="Insecto 1">
      </div>
      <div class="carousel-item">
        <img src="Backend\img\diapositivas prin\mariposa.jpg" class="d-block w-100" alt="Insecto 2">
      </div>
      <div class="carousel-item">
        <img src="Backend\img\diapositivas prin\mariquita.jpg" class="d-block w-100" alt="Insecto 3">
      </div>
      <div class="carousel-item">
        <img src="Backend\img\diapositivas prin\mosca.jpg" class="d-block w-100" alt="Insecto 3">
      </div>
    </div>
  </div>

  <!-- Carrusel de Libros y Biomas -->
<div class="container my-4">
  <div class="row">
    <!-- Libros -->
    <div class="col-md-6">
      <h4 class="section-title">Libros</h4>
      <div id="librosCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner"></div>
        <a class="carousel-control-prev" href="#librosCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#librosCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
      </div>
    </div>



    <!-- Biomas -->
    <div class="col-md-6">
      <h4 class="section-title">Biomas</h4>
      <div id="biomasCarousel" class="carousel slide rounded-carousel" data-ride="carousel" data-interval="3000" data-pause="hover">
            <div class="carousel-inner">
                <div class="carousel-item active position-relative">
                    <img src="Backend/img/biomas/bosque.jpg" class="d-block w-100 rounded" alt="Bosque">
                    <div class="carousel-caption-overlay">Bosque</div>
                </div>
                <div class="carousel-item position-relative">
                    <img src="Backend/img/biomas/desierto.jpg" class="d-block w-100 rounded" alt="Desierto">
                    <div class="carousel-caption-overlay">Desierto</div>
                </div>
                <div class="carousel-item position-relative">
                    <img src="Backend/img/biomas/sabana.jpg" class="d-block w-100 rounded" alt="Sabana">
                    <div class="carousel-caption-overlay">Sabana</div>
                </div>
                <div class="carousel-item position-relative">
                    <img src="Backend/img/biomas/selva.jpg" class="d-block w-100 rounded" alt="Selva">
                    <div class="carousel-caption-overlay">Selva</div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#biomasCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#biomasCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>
    </div>
  </div>
</div>


    <div class="container my-5">
        <h4 class="section-title">¿Qué hay de nuevo?</h4>
        <div id="newsCarousel" class="carousel slide rounded-lg overflow-hidden" data-ride="carousel" data-interval="5000" data-pause="false">
          <div class="carousel-inner" id="newsItemsContainer">
            <!-- Noticias se cargarán dinámicamente aquí -->
          </div>
        </div>
    </div>


  <!-- Insectos Descubiertos -->
    <div class="container my-5">
      <h4 class="section-title">Insectos recientemente descubiertos</h4>
      <div class="row" id="insectosRecientes"></div>
    </div>


  <!-- Pie de Página -->
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

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/principal.js"></script>
</body>
</html>
