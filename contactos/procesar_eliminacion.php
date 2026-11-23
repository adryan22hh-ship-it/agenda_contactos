<?php

include("../includes/verificar_sesion.php");
include("../config/conexion.php");

$id = $_POST['id'];
$id_usuario = $_SESSION['id_usuario'];

// Eliminar únicamente el contacto del usuario
$sql = "DELETE FROM contactos WHERE id = ? AND id_usuario = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $id, $id_usuario);

if ($stmt->execute()) {

    header("Location: listar.php");
    exit();

} else {

    echo "Error al eliminar el contacto.";

}

?>