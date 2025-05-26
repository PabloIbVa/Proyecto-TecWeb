<?php
    require_once __DIR__ . "/../../vendor/autoload.php";

    use myapi\Auth\UserAuth;

    if (empty($_POST["name"])) {
        die("Tiene que colocar un nombre");
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("El email no es válido");
    }

    if (strlen($_POST["password"]) < 8 || 
        !preg_match("/[a-z]/", $_POST["password"]) ||
        !preg_match("/[0-9]/", $_POST["password"])) {
        die("La contraseña debe tener al menos 8 caracteres, una letra y un número");
    }

    if ($_POST["password"] !== $_POST["confirm-password"]) {
        die("Las contraseñas deben coincidir");
    }

    $auth = new UserAuth('bugweb');

    try {
        if ($auth->registerUser($_POST["name"], $_POST["email"], $_POST["password"])) {
            header("Location: http://localhost/Proyecto-TecWeb/proyecto/signup-succes.html");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            die("El email ya está registrado");
        } else {
            die("Error al registrar el usuario: " . $e->getMessage());
        }
    }
?>
