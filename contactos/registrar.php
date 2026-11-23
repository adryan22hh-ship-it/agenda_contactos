<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../usuarios/login.php");
    exit();
}

require_once __DIR__ . '/../config/conexion.php';

// Consultar las categorías disponibles
$sql = "SELECT id, nombre FROM categorias ORDER BY id ASC";
$resultado_categorias = $conexion->query($sql);

if (!$resultado_categorias) {
    die("Error al consultar las categorías: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar contacto | Agenda de Contactos</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<main class="registro-contacto-page">

    <div class="registro-contacto-header">
        <h1>Agregar contacto</h1>
        <p>Registra una nueva persona en tu agenda de contactos.</p>
    </div>

    <section class="registro-contacto-card">

        <div class="registro-contacto-card-header">
            <h2>Información del contacto</h2>
            <p>Completa los siguientes campos con los datos correspondientes.</p>
        </div>

        <form action="procesar_registro.php"
              method="POST"
              class="registro-contacto-form">

            <div class="registro-contacto-grid">

                <div class="registro-contacto-field">
                    <label>Nombre completo *</label>
                    <input
                        type="text"
                        name="nombre"
                        placeholder="Ej. Juan Pérez"
                        required
                    >
                </div>

                <div class="registro-contacto-field">
                    <label>Teléfono *</label>
                    <input
                        type="text"
                        name="telefono"
                        placeholder="Ej. 0991234567"
                        required
                    >
                </div>

                <div class="registro-contacto-field">
                    <label>Correo electrónico</label>
                    <input
                        type="email"
                        name="correo"
                        placeholder="Ej. correo@ejemplo.com"
                    >
                    <span class="registro-contacto-ayuda">
                        Campo opcional.
                    </span>
                </div>

                <div class="registro-contacto-field">
                    <label>Ciudad</label>
                    <input
                        type="text"
                        name="ciudad"
                        placeholder="Ej. Quito"
                    >
                    <span class="registro-contacto-ayuda">
                        Campo opcional.
                    </span>
                </div>

                <!-- Categoría del contacto -->
                <div class="registro-contacto-field">
                    <label>Categoría *</label>

                    <select name="id_categoria" required>
                        <option value="">Selecciona una categoría</option>

                        <?php while ($categoria = $resultado_categorias->fetch_assoc()) { ?>
                            <option value="<?php echo $categoria['id']; ?>">
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <!-- Marcar como favorito -->
                <div class="registro-contacto-field">
                    <label>Contacto favorito</label>

                    <label>
                        <input
                            type="checkbox"
                            name="favorito"
                            value="1"
                        >
                        ⭐ Agregar a mis favoritos
                    </label>

                    <span class="registro-contacto-ayuda">
                        Puedes marcar este contacto como favorito.
                    </span>
                </div>

            </div>

            <div class="registro-contacto-footer">

                <a href="listar.php" class="registro-contacto-cancelar">
                    Cancelar
                </a>

                <button type="submit" class="registro-contacto-guardar">
                    Guardar contacto
                </button>

            </div>

        </form>

    </section>

</main>

</body>
</html>