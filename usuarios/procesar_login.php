<?php

include("../config/conexion.php");

session_start();

// Recibir datos
$correo = trim($_POST['correo']);
$password = $_POST['password'];

// Consultar usuario
$sql = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conexion->prepare($sql);

$stmt->bind_param("s", $correo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {

    $usuario = $resultado->fetch_assoc();

    // Verificar contraseña
    if (password_verify($password, $usuario['password'])) {

        session_regenerate_id(true);

        $_SESSION['id_usuario'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['correo'] = $usuario['correo'];

        header("Location: ../dashboard/index.php");
        exit();

    }

}

// Si las credenciales son incorrectas
echo "Correo o contraseña incorrectos.";

?>