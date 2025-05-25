<?php
    session_start();

    if(isset($_SESSION["user_id"])){
        $mysql = require_once __DIR__ . "/Backend/myapi/database.php";

        $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";

        $result = $mysql->query($sql);

        $user = $result->fetch_assoc();


    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - BugWeb</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: url('https://www.transparenttextures.com/patterns/green-dust-and-scratches.png');
      background-color: #1c1c1c;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .signup-container {
      background-color: #2a2a2a;
      padding: 2rem 2.5rem;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      width: 100%;
      max-width: 400px;
    }

    h1 {
      color: #d4edc9;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      color: #ffffff;
    }

    input {
      width: 100%;
      padding: 0.6rem;
      border: none;
      border-radius: 8px;
      margin-bottom: 1.2rem;
      background-color: #444;
      color: #fff;
    }

    input:focus {
      outline: none;
      background-color: #555;
    }

    button {
      width: 100%;
      padding: 0.75rem;
      background-color: #2e7d32;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #3e9142;
    }
  </style>
</head>
<body>
  <div style="background-color: #2a2a2a">
    <?php if (isset($user)): ?>
      <div class="ods-container" style="max-width: 800px; margin: 0 auto; background-color: #2a2a2a; border-radius: 15px; padding: 2rem;">
        <h2 style="text-align:center; color: #d4edc9;">ODS</h2>
        <h4 style="text-align:center; color: #a5d6a7; margin-bottom: 2rem;">Vida de ecosistemas terrestres</h4>

        <ul class="ods-tabs" style="display: flex; justify-content: center; list-style: none; padding: 0; margin-bottom: 1.5rem; border-bottom: 2px solid #4CAF50;">
          <li><a href="#tab1" class="tab-link active-tab" style="padding: 0.5rem 1.5rem; color: #d4edc9; text-decoration: none; font-weight: bold;">Biodiversidad</a></li>
          <li><a href="#tab2" class="tab-link" style="padding: 0.5rem 1.5rem; color: #d4edc9; text-decoration: none; font-weight: bold;">Deforestación</a></li>
          <li><a href="#tab3" class="tab-link" style="padding: 0.5rem 1.5rem; color: #d4edc9; text-decoration: none; font-weight: bold;">Especies en peligro</a></li>
        </ul>

        <div class="tab-content" id="tab1">
          <h5 style="color: #81c784;">Biodiversidad</h5>
          <p style="color: #fff;">Alrededor del 80% de las especies terrestres habitan en bosques. La protección de estos ecosistemas es clave para mantener el equilibrio natural.</p>
        </div>

        <div class="tab-content" id="tab2" style="display: none;">
          <h5 style="color: #81c784;">Deforestación</h5>
          <p style="color: #fff;">Entre 2015 y 2020, se perdieron más de 10 millones de hectáreas de bosques por año. La agricultura intensiva es una de las principales causas.</p>
        </div>

        <div class="tab-content" id="tab3" style="display: none;">
          <h5 style="color: #81c784;">Especies en peligro</h5>
          <p style="color: #fff;">Más de 31,000 especies están en peligro de extinción, muchas debido a la pérdida de hábitat causada por la actividad humana.</p>
        </div>
      </div>

    <?php else: ?>
        <h1>Error de inicio</h1>
        <p style="color:#e7f2e2; text-align: center;"> No has iniciado sesión</p>
        <p style="color:#e7f2e2; text-align: center;"> <a href="http://localhost/Proyecto-TecWeb/proyecto/login.php">Iniciar sesión</a> o <a href="http://localhost/Proyecto-TecWeb/proyecto/signup.html">Registrate</a></p>
    <?php endif; ?>

  </div>
  <script src="js/ods.js"></script>
</body>
</html>