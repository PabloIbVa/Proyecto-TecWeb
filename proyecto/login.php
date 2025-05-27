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
          header("Location: index.php");
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
  <link rel="stylesheet" href="css/login.css">
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
