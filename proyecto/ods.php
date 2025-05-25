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
  <div class="signup-container">
    <h1>ODS's</h1>

    <?php if (isset($user)): ?>
      <p style="color: #d4edc9; text-align: center;">Ya has iniciado sesión</p>
      <p> Bienvenido, <?php echo htmlspecialchars($user["name"]); ?>!</p>
      <p><a href="http://localhost/Proyecto-TecWeb/proyecto/logout.php">Cerrar sesión</a></p>
    <?php else: ?>
        <p style="color:#e7f2e2; text-align: center;"> No has iniciado sesión</p>
        <p style="color:#e7f2e2; text-align: center;"> <a href="http://localhost/Proyecto-TecWeb/proyecto/login.php">Iniciar sesión</a> o <a href="http://localhost/Proyecto-TecWeb/proyecto/signup.html">Registrate</a></p>
    <?php endif; ?>
    </form>
  </div>
</body>
</html>