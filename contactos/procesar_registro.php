
<?php

session_start();

require_once __DIR__ . '/../config/conexion.php';

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../usuarios/login.php");
    exit();
}

// Verificar que los datos lleguen por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    // Insertar contacto con categoría y favorito
    $consulta = $conexion->prepare(
        "INSERT INTO contactos
        (id_usuario, id_categoria, nombre, telefono, correo, ciudad, favorito)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    $consulta->bind_param(
        "iissssi",
        $id_usuario,
        $id_categoria,
        $nombre,
        $telefono,
        $correo,
        $ciudad,
        $favorito
    );

    if ($consulta->execute()) {

        header("Location: listar.php?mensaje=registrado");
        exit();

    } else {

        echo "Error al registrar el contacto: " . $consulta->error;

    }

} else {

    header("Location: registrar.php");
    exit();

}

?>
