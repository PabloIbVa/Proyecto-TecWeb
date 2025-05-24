<?php 

    if(empty($_POST["name"])){
        die("Tiene que colocar un nombre");
    }

    if( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        die("El email no es valido");
    }

    if(strlen($_POST["password"]) < 8){
        die("La contraseña tiene que tener al menos 8 caracteres");
    }

    if( ! preg_match("/[a-z]/", $_POST["password"])){
        die("La contraseña tiene que tener al menos una letra");
    }

    if( ! preg_match("/[0-9]/", $_POST["password"])){
        die("La contraseña tiene que tener al menos un número");
    }

    if ($_POST["password"] !== $_POST["confirm-password"]) {
        die("Las contraseñas deben coincidir");
    }

    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    print_r($_POST);
    var_dump($password_hash);
?>
