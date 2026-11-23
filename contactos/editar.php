
<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../config/conexion.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id_usuario = $_SESSION['id_usuario'];

// Consultar el contacto
$consulta = $conexion->prepare(
    "SELECT * FROM contactos WHERE id = ? AND id_usuario = ?"
);

$consulta->bind_param("ii", $id, $id_usuario);
$consulta->execute();

$resultado = $consulta->get_result();

if ($resultado->num_rows == 0) {
    die("Contacto no encontrado.");
}

$contacto = $resultado->fetch_assoc();

// Consultar las categorías disponibles
$consulta_categorias = $conexion->prepare(
    "SELECT id, nombre FROM categorias ORDER BY id ASC"
);

$consulta_categorias->execute();
$categorias = $consulta_categorias->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar contacto | Agenda de Contactos</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<main class="editar-contacto-page">

    <div class="editar-contacto-header">
        <div>
            <span class="editar-contacto-etiqueta">GESTIÓN DE CONTACTOS</span>
            <h1>Editar contacto</h1>
            <p>Actualiza la información y mantén tu agenda organizada.</p>
        </div>

        <a href="listar.php" class="editar-volver">
            ← Volver a contactos
        </a>
    </div>

    <section class="editar-contacto-card">

        <div class="editar-contacto-info">
            <div class="editar-contacto-avatar">✎</div>
            <div>
                <h2>Información personal</h2>
                <p>Modifica los datos que deseas actualizar.</p>
            </div>
        </div>

        <form action="procesar_edicion.php" method="POST"
              class="editar-contacto-form">

            <input type="hidden" name="id"
                   value="<?php echo $contacto['id']; ?>">

            <div class="editar-contacto-grid">

                <div class="editar-contacto-field">
                    <label for="nombre">Nombre completo *</label>
                    <input type="text" id="nombre" name="nombre"
                           value="<?php echo htmlspecialchars($contacto['nombre']); ?>"
                           placeholder="Ej. Juan Pérez" required>
                </div>

                <div class="editar-contacto-field">
                    <label for="telefono">Teléfono *</label>
                    <input type="text" id="telefono" name="telefono"
                           value="<?php echo htmlspecialchars($contacto['telefono']); ?>"
                           placeholder="Ej. 0991234567" required>
                </div>

                <div class="editar-contacto-field">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" id="correo" name="correo"
                           value="<?php echo htmlspecialchars($contacto['correo'] ?? ''); ?>"
                           placeholder="Ej. correo@ejemplo.com">
                    <span>Este campo es opcional.</span>
                </div>

                <div class="editar-contacto-field">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" id="ciudad" name="ciudad"
                           value="<?php echo htmlspecialchars($contacto['ciudad'] ?? ''); ?>"
                           placeholder="Ej. Quito">
                    <span>Este campo es opcional.</span>
                </div>

                <!-- Categoría -->
                <div class="editar-contacto-field">
                    <label for="id_categoria">Categoría *</label>

                    <select id="id_categoria" name="id_categoria" required>
                        <?php while ($categoria = $categorias->fetch_assoc()) { ?>
                            <option
                                value="<?php echo $categoria['id']; ?>"
                                <?php echo ($contacto['id_categoria'] == $categoria['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Favorito -->
                <div class="editar-contacto-field">
                    <label>Favorito</label>

                    <label>
                        <input
                            type="checkbox"
                            name="favorito"
                            value="1"
                            <?php echo ($contacto['favorito'] == 1) ? 'checked' : ''; ?>
                        >
                        ⭐ Marcar como favorito
                    </label>
                </div>

            </div>

            <div class="editar-contacto-footer">
                <a href="listar.php" class="editar-btn-cancelar">
                    Cancelar
                </a>

                <button type="submit" class="editar-btn-actualizar">
                    ✓ Actualizar contacto
                </button>
            </div>

        </form>

    </section>

    <p class="editar-contacto-nota">
        Los campos marcados con (*) son obligatorios.
    </p>

</main>

</body>
</html>
