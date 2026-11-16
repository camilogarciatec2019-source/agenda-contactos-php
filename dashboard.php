<?php
session_start();
require_once 'conexion.php';

// Verificación estricta de sesión activa
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener contactos pertenecientes ÚNICAMENTE al usuario logueado
$stmt = $conexion->prepare("SELECT id, nombre, telefono, correo, ciudad FROM contactos WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$contactos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Contactos</title>
</head>
<body>
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['nombre_usuario']); ?></h1>
    <p><strong>Correo:</strong> <?= htmlspecialchars($_SESSION['correo_usuario']); ?></p>
    <p><a href="logout.php">Cerrar Sesión</a></p>

    <hr>
    <h2>Mis Contactos</h2>
    <a href="guardar_contacto.php">+ Agregar Nuevo Contacto</a><br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Ciudad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($contactos->num_rows > 0): ?>
                <?php while ($row = $contactos->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nombre']); ?></td>
                        <td><?= htmlspecialchars($row['telefono']); ?></td>
                        <td><?= htmlspecialchars($row['correo']); ?></td>
                        <td><?= htmlspecialchars($row['ciudad']); ?></td>
                        <td>
                            <a href="editar_contacto.php?id=<?= $row['id']; ?>">Editar</a> |
                            <a href="eliminar_contacto.php?id=<?= $row['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este contacto?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No tienes contactos registrados en tu agenda.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>