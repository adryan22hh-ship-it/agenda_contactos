
<?php

require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../config/conexion.php';

// Verificar que los datos lleguen mediante POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: listar.php");
    exit();
}

// Recibir los datos
$id = intval($_POST['id']);
$nombre = trim($_POST['nombre']);
$telefono = trim($_POST['telefono']);
$correo = trim($_POST['correo']);
$ciudad = trim($_POST['ciudad']);
$id_categoria = intval($_POST['id_categoria']);

$favorito = isset($_POST['favorito']) ? 1 : 0;

$id_usuario = $_SESSION['id_usuario'];

// Verificar que la categoría exista
$verificar = $conexion->prepare(
    "SELECT id FROM categorias WHERE id = ?"
);

$verificar->bind_param("i", $id_categoria);
$verificar->execute();

$resultado = $verificar->get_result();

if ($resultado->num_rows == 0) {
    die("La categoría seleccionada no es válida.");
}

// Actualizar el contacto
$sql = "UPDATE contactos
        SET nombre = ?,
            telefono = ?,
            correo = ?,
            ciudad = ?,
            id_categoria = ?,
            favorito = ?
        WHERE id = ? AND id_usuario = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "ssssiiii",
    $nombre,
    $telefono,
    $correo,
    $ciudad,
    $id_categoria,
    $favorito,
    $id,
    $id_usuario
);

if ($stmt->execute()) {

    header("Location: listar.php?mensaje=actualizado");
    exit();

} else {

    echo "Error al actualizar el contacto: " . $stmt->error;

}

?>
