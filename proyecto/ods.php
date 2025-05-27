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
  <title>Registro - BugWeb</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/ods.css">
</head>
<body>
  <div style="background-color: #2a2a2a">
    <?php if (isset($user)): ?>
      <div class="ods-container">
        <h2>ODS</h2>
        <h4>Vida de ecosistemas terrestres</h4>

            <ul class="ods-tabs" style="display: flex; justify-content: center; list-style: none; padding: 0; margin-bottom: 1.5rem; border-bottom: 2px solid #4CAF50;">
              <li><a href="#tab1" class="tab-link active-tab" style="padding: 0.5rem 1.5rem; color: #d4edc9; text-decoration: none; font-weight: bold;">Metas</a></li>
              <li><a href="#tab2" class="tab-link" style="padding: 0.5rem 1.5rem; color: #d4edc9; text-decoration: none; font-weight: bold;">Proposito</a></li>
              <li><a href="#tab3" class="tab-link" style="padding: 0.5rem 1.5rem; color: #d4edc9; text-decoration: none; font-weight: bold;">Metas de ODS</a></li>
            </ul>

            <div class="tab-content active" id="tab1">
              <h5 style="color: #81c784;">Metas Principales</h5>
              <p>
                  <strong>Descripción:</strong> Este objetivo busca proteger, restaurar y promover el uso sostenible de los ecosistemas terrestres,
                  gestionar de forma sostenible los bosques, luchar contra la desertificación, detener e invertir la degradación de la tierra
                  y frenar la pérdida de biodiversidad.
              </p>

              <p>
                  <strong>Principales metas:</strong><br>
                  • Conservación de ecosistemas terrestres y de agua dulce.<br>
                  • Gestión sostenible de bosques<br>
                  • Lucha contra la desertificación<br>
                  • Conservación de la biodiversidad<br>
                  • Acceso a beneficios de los recursos genéticos<br>
                  • Combatir la caza furtiva y el tráfico de especies.<br>
                  • Integración de los valores de los ecosistemas en políticas nacionales.<br>
                  • Movilizar recursos para conservar la biodiversidad.
              </p>
            </div>

            <div class="tab-content" id="tab2" style="display: none;">
              <h5 style="color: #81c784;">Proposito o papel que tendra la aplicacion web para la solucion del ODS:</h5>
              <p>
                La página web actúa como unaherramienta educativa e interactiva que promueve la conciencia sobre la importancia ecológica de los
                insectos y su papel en los ecosistemas terrestres. Al difundir información accesible sobre especies nativas,
                sus funciones en la naturaleza y las amenazas que enfrentan, el proyecto contribuye directamente a la
                meta de detener la pérdida de biodiversidad.
                </p>

                <p>
                La página web, titulada provisionalmente <strong>BugWeb</strong>, se plantea como una herramienta digital moderna y
                accesible que permita a estudiantes, docentes, investigadores y público general explorar la diversidad de
                insectos mexicanos mediante recursos interactivos, fichas informativas, galerías visuales, mapas
                geográficos de distribución, actividades didácticas y datos científicos confiables.
                </p>

                <p>
                Además, el proyecto fomenta el desarrollo de habilidades digitales, el pensamiento crítico y el compromiso ambiental en niños
                y jóvenes, al tiempo que promueve la colaboración entre comunidades escolares, universidades, museos
                de ciencias naturales y organizaciones civiles enfocadas en la biodiversidad.
                </p>
            </div>

            <div class="tab-content" id="tab3" style="display: none;">
              <h5 style="color: #81c784;">Metas cumplidas de nuestro ODS</h5>
              <p style="color: #fff;">Más de 31,000 especies están en peligro de extinción, muchas debido a la pérdida de hábitat causada por la actividad humana.</p>
            </div>
          </div>

      </div>

    <?php else: ?>
        <h1>Error de inicio</h1>
        <p style="color:#e7f2e2; text-align: center;"> No has iniciado sesión</p>
        <p style="color:#e7f2e2; text-align: center;"> <a href="http://localhost/Proyecto-TecWeb/proyecto/login.php">Iniciar sesión</a> o <a href="http://localhost/Proyecto-TecWeb/proyecto/signup.html">Registrate</a></p>
    <?php endif; ?>

  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/ods.js"></script>
</body>
</html>