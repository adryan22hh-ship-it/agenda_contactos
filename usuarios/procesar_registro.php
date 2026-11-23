
<?php

require_once __DIR__ . '/../config/conexion.php';

$exito = false;
$titulo = "";
$mensaje = "";
$clase = "error";
$icono = "✕";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];

    // Verificar si el correo ya está registrado
    $verificar = $conexion->prepare(
        "SELECT id FROM usuarios WHERE correo = ?"
    );

    $verificar->bind_param("s", $correo);
    $verificar->execute();

    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {

        $titulo = "Correo ya registrado";
        $mensaje = "Este correo electrónico ya tiene una cuenta. Intenta iniciar sesión.";
        
    } else {

        // Encriptar contraseña
        $password_segura = password_hash($password, PASSWORD_DEFAULT);

        // Registrar usuario
        $consulta = $conexion->prepare(
            "INSERT INTO usuarios (nombre, correo, password)
             VALUES (?, ?, ?)"
        );

        $consulta->bind_param(
            "sss",
            $nombre,
            $correo,
            $password_segura
        );

        if ($consulta->execute()) {

            $exito = true;
            $clase = "exito";
            $icono = "✓";
            $titulo = "¡Registro exitoso!";
            $mensaje = "Tu cuenta se ha creado correctamente. Ya puedes iniciar sesión y comenzar a utilizar tu agenda de contactos.";

        } else {

            $titulo = "No se pudo completar el registro";
            $mensaje = "Ocurrió un problema al crear tu cuenta. Inténtalo nuevamente.";

        }

    }

} else {

    $titulo = "Acceso no permitido";
    $mensaje = "Debes completar el formulario de registro para continuar.";

}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo); ?> | Agenda de Contactos</title>

    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>

    <div class="resultado-page">

        <div class="resultado-card">

            <div class="resultado-icono <?php echo $clase; ?>">
                <?php echo $icono; ?>
            </div>

            <span class="resultado-etiqueta">
                AGENDA DE CONTACTOS
            </span>

            <h1>
                <?php echo htmlspecialchars($titulo); ?>
            </h1>

            <p class="resultado-mensaje">
                <?php echo htmlspecialchars($mensaje); ?>
            </p>

            <?php if ($exito) { ?>

                <div class="resultado-detalle">
                    <span>✓</span>
                    Tu cuenta ya está lista para utilizarse.
                </div>

                <a href="login.php" class="resultado-boton">
                    Iniciar sesión
                    <span>→</span>
                </a>

            <?php } else { ?>

                <a href="registro.php" class="resultado-boton">
                    Volver al registro
                    <span>→</span>
                </a>

                <a href="login.php" class="resultado-enlace">
                    ¿Ya tienes una cuenta? Inicia sesión
                </a>

            <?php } ?>

        </div>

        <p class="resultado-pie">
            Agenda de Contactos · Organiza tu información fácilmente
        </p>

    </div>

</body>
</html>
