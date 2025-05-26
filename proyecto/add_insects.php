<?php
require_once __DIR__ . "/vendor/autoload.php";

use myapi\Auth\UserAuth;

session_start();

$user = null;

if (isset($_SESSION["user_id"])) {
    $auth = new UserAuth('bugweb');
    $user = $auth->getUserById($_SESSION["user_id"]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Añadir Insectos</title>
  <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* COPIA TODO TU ESTILO AQUÍ (del .html original) */
    body {
      background: url('https://www.transparenttextures.com/patterns/green-dust-and-scratches.png');
      background-color: #1c1c1c;
      font-family: 'Poppins', sans-serif;
    }
    .wrapper { display: flex; flex-direction: column; min-height: 100vh; }
    .container { flex: 1; }
    header { background-color: #2e7d32; color: white; }
    .logo { width: 50px; height: auto; }
    .sidebar-menu {
      position: fixed; top: 0; right: 0; height: 100%; width: 250px;
      background-color: #2a2a2a; padding: 2rem 1rem; display: flex;
      flex-direction: column; z-index: 1050; box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
      transform: translateX(100%); opacity: 0; pointer-events: none;
      transition: transform 0.3s ease, opacity 0.3s ease;
    }
    .sidebar-menu.show {
      transform: translateX(0); opacity: 1; pointer-events: auto;
    }
    .sidebar-menu a {
      color: #fff; text-decoration: none; padding: 0.5rem 0; font-weight: bold;
    }
    .card, .table {
      border: none; border-radius: 20px; background-color: #2e2e2e;
      backdrop-filter: blur(4px); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s ease;
    }
    .card:hover { transform: scale(1.03); }
    footer { background-color: #2f4f2f; }
    footer h5, footer h6, footer p { color: #d4edc9; }
    .menu-btn { background-color: transparent; border: none; font-size: 1.7rem; color: white; }
    .menu-btn:hover { color: #cdeccd; }
    .animated-header { animation: bounceIn 1.5s; }
    @keyframes bounceIn {
      0% { transform: scale(0.3); opacity: 0; }
      50% { transform: scale(1.05); opacity: 1; }
      70% { transform: scale(0.9); }
      100% { transform: scale(1); }
    }
  </style>
</head>
<body onclick="closeMenu(event)">
  <div class="wrapper">
    <header class="d-flex justify-content-between align-items-center p-3 animated-header">
      <div class="d-flex align-items-center">
        <img src="Backend/img/logo/lotus-with-hands-1889661_1280.png" alt="Logo" class="logo me-2">
        <h3 class="m-0">BugWeb</h3>
      </div>
      <form class="form-inline my-2 my-lg-0 ml-auto mr-3" style="max-width: 350px; min-width: 250px;">
        <input class="form-control mr-sm-2" name="search" id="search" type="search" placeholder="ID, nombre o familia" aria-label="Search">
        <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
      </form>
      <button class="menu-btn" onclick="toggleMenu()">
        <i class="bi bi-bug-fill"></i>
      </button>
    </header>

    <div class="sidebar-menu" id="sidebarMenu">
      <a href="">Añadir noticia</a>
      <a href="add_insects.php">Añadir nuevo insecto</a>
      <a href="add_books.html">Añadir libro</a>
      <a href="ods.php">ODS</a>
      <a href="index.html">Ir a página principal</a>
    </div>

    <div class="container p-4">
      <?php if (isset($user)): ?>
        <!-- Mostrar formulario solo si está logueado -->
        <div class="row">
          <div class="col-md-5">
            <div class="card">
              <div class="card-body">
                <form id="insect-form">
                  <div class="form-group">
                    <label for="name">Nombre del insecto:</label>
                    <input class="form-control" type="text" id="name" placeholder="Nombre del insecto" required>
                  </div>
                  <div class="form-group">
                    <fieldset>
                      <label for="familia">Familia:</label>
                      <input type="text" id="familia" name="familia" class="form-control" required>

                      <label for="nombre_c">Nombre científico:</label>
                      <input type="text" id="nombre_c" name="nombre_c" class="form-control" required>

                      <label for="estado">Estado:</label>
                      <select name="estado" id="estado" class="form-control">
                        <option value="1">Extinta</option>
                        <option value="2">Extinta en estado silvestre</option>
                        <option value="3">En peligro crítico de extinción</option>
                        <option value="4">En peligro de extinción</option>
                        <option value="5">Vulnerable</option>
                        <option value="6">Casi amenazada</option>
                        <option value="7">Preocupación menor</option>
                        <option value="0">Datos deficientes</option>
                      </select>

                      <label for="descripcion">Descripción:</label>
                      <input type="textarea" id="descripcion" name="descripcion" class="form-control" required>

                      <label for="habitad">Hábitat:</label>
                      <input type="text" id="habitad" name="habitad" class="form-control" required>

                      <label for="alimentacion">Alimentación:</label>
                      <input type="text" id="alimentacion" name="alimentacion" class="form-control" required>

                      <label for="longevidad">Longevidad:</label>
                      <input type="text" id="longevidad" name="longevidad" class="form-control" required>

                      <label for="imagen">Imagen:</label> 
                      <input type="text" id="imagen" name="imagen" class="form-control" required value="Backend/img/insect/default.png">
                    </fieldset>
                  </div>
                  <input type="hidden" id="productId">
                  <button class="btn btn-primary btn-block text-center" type="submit">
                    Agregar Insecto
                  </button>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-7">
            <div class="card my-4 d-none" id="product-result">
              <div class="card-body">
                <ul id="container"></ul>
              </div>
            </div>

            <table class="table table-bordered table-sm">
              <thead>
                <tr>
                  <td>Id</td>
                  <td>Nombre</td>
                  <td>Descripción</td>
                </tr>
              </thead>
              <tbody id="insects"></tbody>
            </table>
          </div>
        </div>
      <?php else: ?>
        <!-- Mostrar mensaje si no ha iniciado sesión -->
        <div class="text-center">
          <h1>Error de inicio</h1>
          <p style="color:#e7f2e2;">No has iniciado sesión</p>
          <p style="color:#e7f2e2;">
            <a href="http://localhost/Proyecto-TecWeb/proyecto/login.php">Iniciar sesión</a> o 
            <a href="http://localhost/Proyecto-TecWeb/proyecto/signup.html">Registrarse</a>
          </p>
        </div>
      <?php endif; ?>
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
          <div class="col-md-3">
            <h6>Legales</h6>
            <p>Avisos de privacidad y términos de uso</p>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="js/appInsects.js"></script>
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
