<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "agenda_db";

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Establecer conjunto de caracteres UTF-8
$conexion->set_charset("utf8mb4");
?>