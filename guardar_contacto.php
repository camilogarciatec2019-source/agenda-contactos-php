<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $correo   = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $ciudad   = trim($_POST['ciudad']);
    $id_user  = $_SESSION['id_usuario'];

    if (!empty($nombre) && !empty($telefono)) {
        $stmt = $conexion->prepare("INSERT INTO contactos (id_usuario, nombre, telefono, correo, ciudad) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $id_user, $nombre, $telefono, $correo, $ciudad);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Contacto</title>
</head>
<body>
    <h2>Agregar Contacto</h2>
    <form action="guardar_contacto.php" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Teléfono:</label><br>
        <input type="text" name="telefono" required><br><br>

        <label>Correo:</label><br>
        <input type="email" name="correo" required><br><br>

        <label>Ciudad:</label><br>
        <input type="text" name="ciudad" required><br><br>

        <button type="submit">Guardar Contacto</button>
        <a href="dashboard.php">Cancelar</a>
    </form>
</body>
</html>