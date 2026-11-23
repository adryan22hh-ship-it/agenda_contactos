<?php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {

    header("Location: /agenda_contactos/usuarios/login.php");
    exit();

}

?>