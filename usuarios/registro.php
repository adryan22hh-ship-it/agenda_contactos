
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
    <title>Crear cuenta | Agenda de Contactos</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<div class="form-card">

    <div class="form-header">
        
        <h1>Crear cuenta</h1>
        <p>Regístrate para comenzar a utilizar tu agenda</p>
    </div>

    <form action="procesar_registro.php" method="POST">

        <div class="form-field">
            <label>Nombre completo</label>
            <input type="text" name="nombre"
                   placeholder="Ingresa tu nombre completo" required>
        </div>

        <div class="form-field">
            <label>Correo electrónico</label>
            <input type="email" name="correo"
                   placeholder="ejemplo@correo.com" required>
        </div>

        <div class="form-field">
            <label>Contraseña</label>
            <input type="password" name="password"
                   placeholder="Crea una contraseña" required>
        </div>

        <button type="submit">Crear mi cuenta</button>

    </form>

    <div class="form-footer">
        <p>¿Ya tienes una cuenta?</p>
        <a href="login.php">Iniciar sesión</a>
    </div>

</div>

</body>
</html>
