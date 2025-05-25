<?php
    session_start();
    session_destroy();
    header("Location: http://localhost/Proyecto-TecWeb/proyecto/ods.php");
    exit;
?>