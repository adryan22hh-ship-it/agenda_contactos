
<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../config/conexion.php';

$nombre = $_SESSION['nombre'];
$id_usuario = $_SESSION['id_usuario'];

// Obtener estadísticas de los contactos
$consulta_estadisticas = $conexion->prepare(
    "SELECT
        COUNT(*) AS total,
        COUNT(DISTINCT NULLIF(ciudad, '')) AS ciudades,
        SUM(CASE WHEN correo IS NOT NULL AND correo <> '' THEN 1 ELSE 0 END) AS con_correo,
        SUM(CASE WHEN favorito = 1 THEN 1 ELSE 0 END) AS favoritos
     FROM contactos
     WHERE id_usuario = ?"
);

$consulta_estadisticas->bind_param("i", $id_usuario);
$consulta_estadisticas->execute();

$estadisticas = $consulta_estadisticas->get_result()->fetch_assoc();

// Obtener los últimos cinco contactos con su categoría
$consulta_contactos = $conexion->prepare(
    "SELECT contactos.*, categorias.nombre AS categoria
     FROM contactos
     INNER JOIN categorias ON contactos.id_categoria = categorias.id
     WHERE contactos.id_usuario = ?
     ORDER BY contactos.id DESC
     LIMIT 5"
);

$consulta_contactos->bind_param("i", $id_usuario);
$consulta_contactos->execute();

$resultado = $consulta_contactos->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Agenda de Contactos</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="dashboard-page">

    <!-- BIENVENIDA -->
    <section class="dashboard-bienvenida">

        <h1>
            ¡Hola, <?php echo htmlspecialchars($nombre); ?>!
        </h1>

        <p>
            Bienvenido a tu agenda de contactos.
            Administra y organiza tu información desde aquí.
        </p>

        <div class="dashboard-accesos">

            <a href="../contactos/registrar.php"
               class="dashboard-btn dashboard-btn-principal">
                + Agregar contacto
            </a>

            <a href="../contactos/listar.php"
               class="dashboard-btn dashboard-btn-secundario">
                Ver todos los contactos
            </a>

            <a href="../contactos/listar.php?favoritos=1"
               class="dashboard-btn dashboard-btn-secundario">
                ⭐ Ver favoritos
            </a>

        </div>

    </section>

    <!-- ESTADÍSTICAS -->
    <h2 class="dashboard-titulo">Resumen de tu agenda</h2>

    <section class="dashboard-estadisticas">

        <div class="dashboard-card">
            <div class="dashboard-card-icon">👥</div>
            <span>Total de contactos</span>
            <h2>
                <?php echo $estadisticas['total'] ?? 0; ?>
            </h2>
        </div>

        <div class="dashboard-card">
            <div class="dashboard-card-icon">📍</div>
            <span>Ciudades registradas</span>
            <h2>
                <?php echo $estadisticas['ciudades'] ?? 0; ?>
            </h2>
        </div>

        <div class="dashboard-card">
            <div class="dashboard-card-icon">✉️</div>
            <span>Contactos con correo</span>
            <h2>
                <?php echo $estadisticas['con_correo'] ?? 0; ?>
            </h2>
        </div>

        <div class="dashboard-card">
            <div class="dashboard-card-icon">⭐</div>
            <span>Contactos favoritos</span>
            <h2>
                <?php echo $estadisticas['favoritos'] ?? 0; ?>
            </h2>
        </div>

    </section>

    <!-- CONTACTOS RECIENTES -->
    <section class="dashboard-seccion">

        <div class="dashboard-seccion-header">

            <h2>Contactos recientes</h2>

            <a href="../contactos/listar.php"
               class="dashboard-ver-todos">
                Ver todos →
            </a>

        </div>

        <?php if ($resultado->num_rows > 0) { ?>

            <div class="dashboard-tabla-contenedor">

                <table class="dashboard-tabla">

                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Ciudad</th>
                            <th>Categoría</th>
                            <th>Favorito</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php while ($contacto = $resultado->fetch_assoc()) { ?>

                            <tr>

                                <td>
                                    <?php echo htmlspecialchars($contacto['nombre']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($contacto['telefono']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($contacto['correo'] ?? ''); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($contacto['ciudad'] ?? ''); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($contacto['categoria']); ?>
                                </td>

                                <td>
                                    <?php
                                    echo ($contacto['favorito'] == 1)
                                        ? '⭐ Sí'
                                        : 'No';
                                    ?>
                                </td>

                                <td>
                                    <div class="dashboard-acciones">

                                        <a href="../contactos/editar.php?id=<?php echo $contacto['id']; ?>"
                                           class="btn-editar">
                                            Editar
                                        </a>

                                        <a href="../contactos/eliminar.php?id=<?php echo $contacto['id']; ?>"
                                           class="btn-eliminar"
                                           onclick="return confirm('¿Estás seguro de eliminar este contacto?')">
                                            Eliminar
                                        </a>

                                    </div>
                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        <?php } else { ?>

            <div class="dashboard-vacio">
                <h3>Tu agenda está vacía</h3>
                <p>Agrega tu primer contacto para comenzar a organizar tu información.</p>
            </div>

        <?php } ?>

    </section>

</div>

</body>
</html>
