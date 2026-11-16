<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_contacto = intval($_GET['id']);
    $id_usuario  = $_SESSION['id_usuario'];

    // Eliminar solo si el contacto pertenece al usuario autenticado
    $stmt = $conexion->prepare("DELETE FROM contactos WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id_contacto, $id_usuario);
    $stmt->execute();
    $stmt->close();
}

header("Location: dashboard.php");
exit();
?>