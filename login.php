<?php
session_start();
require_once 'conexion.php';
$mensaje = '';

if (isset($_GET['registro']) && $_GET['registro'] === 'exito') {
    $mensaje = "<div style='color:green;'>¡Registro exitoso! Por favor inicia sesión.</div>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo   = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!empty($correo) && !empty($password)) {
        $stmt = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($usuario = $resultado->fetch_assoc()) {
            if (password_verify($password, $usuario['password'])) {
                // Iniciar sesión y guardar variables clave
                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre'];
                $_SESSION['correo_usuario'] = $correo;

                header("Location: dashboard.php");
                exit();
            } else {
                $mensaje = "<div style='color:red;'>Credenciales incorrectas.</div>";
            }
        } else {
            $mensaje = "<div style='color:red;'>Credenciales incorrectas.</div>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?= $mensaje; ?>
    <form action="login.php" method="POST">
        <label>Correo electrónico:</label><br>
        <input type="email" name="correo" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Ingresar</button>
    </form>
    <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
</body>
</html>