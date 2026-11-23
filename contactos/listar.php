
<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../usuarios/login.php");
    exit();
}

require_once __DIR__ . '/../config/conexion.php';

$id_usuario = $_SESSION['id_usuario'];

// Comprobar si se quieren mostrar solamente los favoritos
$solo_favoritos = isset($_GET['favoritos']) && $_GET['favoritos'] == '1';

// Consultar contactos junto con su categoría
$sql = "SELECT contactos.*, categorias.nombre AS categoria
        FROM contactos
        INNER JOIN categorias ON contactos.id_categoria = categorias.id
        WHERE contactos.id_usuario = ?";

if ($solo_favoritos) {
    $sql .= " AND contactos.favorito = 1";
}

$sql .= " ORDER BY contactos.nombre ASC";

$consulta = $conexion->prepare($sql);
$consulta->bind_param("i", $id_usuario);
$consulta->execute();

$resultado = $consulta->get_result();
$total = $resultado->num_rows;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis contactos | Agenda de Contactos</title>

    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>

    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="contactos-page">

        <div class="contactos-header">

            <div>
                <h1>
                    <?php echo $solo_favoritos ? 'Mis favoritos' : 'Mis contactos'; ?>
                </h1>

                <p>
                    <?php echo $solo_favoritos
                        ? 'Consulta y administra tus contactos favoritos.'
                        : 'Administra y organiza todos tus contactos.'; ?>
                </p>
            </div>

            <a href="registrar.php" class="btn-agregar">
                + Agregar contacto
            </a>

        </div>

        <div class="contactos-resumen">

            <span>
                <?php echo $solo_favoritos
                    ? 'Total de favoritos'
                    : 'Total de contactos registrados'; ?>
            </span>

            <h2><?php echo $total; ?></h2>

        </div>

        <div class="contactos-tabla">

            <div class="contactos-tabla-header">

                <h2 class="titulo-lista-contactos">
                    Lista de contactos
                </h2>

                <input
                    type="text"
                    id="buscadorContactos"
                    class="contactos-buscador"
                    placeholder="Buscar contacto..."
                >

            </div>

            <!-- FILTROS DE CONTACTOS -->
            <div class="contactos-filtros">

                <a href="listar.php"
                   class="filtro-contacto <?php echo !$solo_favoritos ? 'activo' : ''; ?>">
                    👥 Todos los contactos
                </a>

                <a href="listar.php?favoritos=1"
                   class="filtro-contacto <?php echo $solo_favoritos ? 'activo' : ''; ?>">
                    ⭐ Mis favoritos
                </a>

            </div>

            <div class="tabla-contenedor">

                <table>

                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo electrónico</th>
                            <th>Ciudad</th>
                            <th>Categoría</th>
                            <th>Favorito</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaContactos">

                        <?php if ($total > 0) { ?>

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
                                        <?php echo $contacto['favorito'] == 1 ? '★ Sí' : '☆ No'; ?>
                                    </td>

                                    <td>
                                        <div class="acciones-contacto">

                                            <a
                                                href="editar.php?id=<?php echo $contacto['id']; ?>"
                                                class="btn-editar">
                                                Editar
                                            </a>

                                            <a
                                                href="eliminar.php?id=<?php echo $contacto['id']; ?>"
                                                class="btn-eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar este contacto?')">
                                                Eliminar
                                            </a>

                                        </div>
                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="7">

                                    <div class="contactos-vacio">

                                        <h3>
                                            <?php echo $solo_favoritos
                                                ? 'Aún no tienes favoritos'
                                                : 'Aún no tienes contactos'; ?>
                                        </h3>

                                        <p>
                                            <?php echo $solo_favoritos
                                                ? 'Marca tus contactos como favoritos para verlos aquí.'
                                                : 'Agrega tu primer contacto para comenzar.'; ?>
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

            <p id="sinResultados" class="contactos-vacio" style="display:none;">
                No se encontraron contactos con esa búsqueda.
            </p>

        </div>

    </div>

    <script>
        const buscador = document.getElementById('buscadorContactos');

        buscador.addEventListener('input', function () {

            const texto = this.value.toLowerCase();
            const filas = document.querySelectorAll('#tablaContactos tr');

            let encontrados = 0;

            filas.forEach(function (fila) {

                const contenido = fila.textContent.toLowerCase();

                if (contenido.includes(texto)) {
                    fila.style.display = '';
                    encontrados++;
                } else {
                    fila.style.display = 'none';
                }

            });

            document.getElementById('sinResultados').style.display =
                encontrados === 0 ? 'block' : 'none';

        });
    </script>

</body>
</html>
