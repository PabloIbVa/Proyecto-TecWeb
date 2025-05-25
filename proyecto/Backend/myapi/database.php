<?php
    $host = 'localhost';
    $dbname = 'bugweb';
    $username = 'root';
    $password = 'W0lverine';

    $mysqli = new mysqli($host, $username, $password, $dbname);
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    return $mysqli;
?>