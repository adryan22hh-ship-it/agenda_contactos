
<?php

require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../config/conexion.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: listar.php");
    exit();
}

$id = intval($_GET['id']);
$id_usuario = $_SESSION['id_usuario'];

$consulta = $conexion->prepare(
    "SELECT nombre FROM contactos WHERE id = ? AND id_usuario = ?"
);

$consulta->bind_param("ii", $id, $id_usuario);
$consulta->execute();

$resultado = $consulta->get_result();

if ($resultado->num_rows == 0) {
    header("Location: listar.php");
    exit();
}

$contacto = $resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar contacto | Agenda de Contactos</title>

    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>

    <div class="eliminar-page">

        <div class="eliminar-card">

            <div class="eliminar-icono">
                !
            </div>

            <span class="eliminar-etiqueta">
                AGENDA DE CONTACTOS
            </span>

            <h1>¿Eliminar contacto?</h1>

            <p class="eliminar-mensaje">
                ¿Estás seguro de que deseas eliminar este contacto?
            </p>

            <div class="eliminar-nombre">
                <?php echo htmlspecialchars($contacto['nombre']); ?>
            </div>

            <p class="eliminar-aviso">
                Esta acción no se puede deshacer. El contacto será eliminado permanentemente de tu agenda.
            </p>

            <form action="procesar_eliminacion.php" method="POST" class="eliminar-acciones">

                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <button type="submit" class="eliminar-boton">
                    Sí, eliminar contacto
                </button>

                <a href="listar.php" class="eliminar-cancelar">
                    Cancelar
                </a>

            </form>

        </div>

        <p class="eliminar-pie">
            Agenda de Contactos · Organiza tu información fácilmente
        </p>

    </div>

</body>
</html>
