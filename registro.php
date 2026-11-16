<?php
require_once 'conexion.php';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre']);
    $correo   = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!empty($nombre) && !empty($correo) && !empty($password)) {
        // Validar si el correo ya existe
        $stmt_check = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt_check->bind_param("s", $correo);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $mensaje = "<div style='color:red;'>El correo electrónico ya está registrado.</div>";
        } else {
            // Encriptar contraseña de manera segura
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);

            // Insertar nuevo usuario
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $correo, $password_hashed);

            if ($stmt->execute()) {
                header("Location: login.php?registro=exito");
                exit();
            } else {
                $mensaje = "<div style='color:red;'>Error al registrar el usuario.</div>";
            }
            $stmt->close();
        }
        $stmt_check->close();
    } else {
        $mensaje = "<div style='color:red;'>Por favor, completa todos los campos.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Crear Cuenta</h2>
    <?= $mensaje; ?>
    <form action="registro.php" method="POST">
        <label>Nombre completo:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Correo electrónico:</label><br>
        <input type="email" name="correo" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</body>
</html>