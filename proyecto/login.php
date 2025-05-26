<?php
  require_once __DIR__ . "/vendor/autoload.php";

  use myapi\Auth\UserAuth;

  $is_invalid = false;

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $auth = new UserAuth('bugweb');  // Usa la nueva clase
      $user = $auth->getUserByEmail($_POST["email"]);

      if ($user && password_verify($_POST["password"], $user["password_hash"])) {
          session_start();
          session_regenerate_id();
          $_SESSION["user_id"] = $user["id"];
          header("Location: ods.php");
          exit;
      }

      $is_invalid = true;
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio Sesión - BugWeb</title>
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
      box-sizing: border-box;
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
      box-sizing: border-box;
    }

    input:focus {
      outline: none;
      background-color: #555;
    }

    .button-wrapper {
      display: flex;
      justify-content: center;
    }

    button {
      padding: 0.6rem 2rem;
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

    .error-message {
      color: #f88;
      background-color: #442222;
      padding: 0.5rem;
      border-radius: 8px;
      margin-bottom: 1rem;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <h1>Inicio de Sesión</h1>

    <?php if ($is_invalid): ?>
      <div class="error-message">Correo o contraseña inválidos</div>
    <?php endif; ?>

    <form method="post" novalidate>
      <div>
        <label for="email">Correo:</label>
        <input type="text" id="email" name="email" placeholder="Ingresa tu correo electronido"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
      </div>

      <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required placeholder="Ingresa tu contraseña">
      </div>

      <div class="button-wrapper">
        <button type="submit">Iniciar sesión</button>
      </div>
    </form>
  </div>
</body>
</html>
