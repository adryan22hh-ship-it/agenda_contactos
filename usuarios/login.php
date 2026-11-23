<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: ../dashboard/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Agenda de Contactos</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<div class="login-card">

    <div class="login-header">
        

        <h1>Bienvenido</h1>
        <p>Ingresa a tu agenda de contactos</p>
    </div>

    <form action="procesar_login.php" method="POST">

        <div class="login-field">
            <label>Correo electrónico</label>
            <input type="email" name="correo"
                   placeholder="Ingresa tu correo" required>
        </div>

        <div class="login-field">
            <label>Contraseña</label>
            <input type="password" name="password"
                   placeholder="Ingresa tu contraseña" required>
        </div>

        <button type="submit">Iniciar sesión</button>

    </form>

    <div class="login-footer">
        <p>¿No tienes una cuenta?</p>
        <a href="registro.php">Registrarse</a>
    </div>

</div>

</body>
</html>