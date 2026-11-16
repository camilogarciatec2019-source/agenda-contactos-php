<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$id_contacto = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verificar que el contacto pertenezca al usuario logueado
$stmt = $conexion->prepare("SELECT nombre, telefono, correo, ciudad FROM contactos WHERE id = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id_contacto, $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    // Si no le pertenece o no existe, redirigir
    header("Location: dashboard.php");
    exit();
}

$contacto = $resultado->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $correo   = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $ciudad   = trim($_POST['ciudad']);

    $stmt_update = $conexion->prepare("UPDATE contactos SET nombre = ?, telefono = ?, correo = ?, ciudad = ? WHERE id = ? AND id_usuario = ?");
    $stmt_update->bind_param("ssssii", $nombre, $telefono, $correo, $ciudad, $id_contacto, $id_usuario);

    if ($stmt_update->execute()) {
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Contacto</title>
</head>
<body>
    <h2>Editar Contacto</h2>
    <form action="editar_contacto.php?id=<?= $id_contacto; ?>" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= htmlspecialchars($contacto['nombre']); ?>" required><br><br>

        <label>Teléfono:</label><br>
        <input type="text" name="telefono" value="<?= htmlspecialchars($contacto['telefono']); ?>" required><br><br>

        <label>Correo:</label><br>
        <input type="email" name="correo" value="<?= htmlspecialchars($contacto['correo']); ?>" required><br><br>

        <label>Ciudad:</label><br>
        <input type="text" name="ciudad" value="<?= htmlspecialchars($contacto['ciudad']); ?>" required><br><br>

        <button type="submit">Actualizar Contacto</button>
        <a href="dashboard.php">Cancelar</a>
    </form>
</body>
</html>