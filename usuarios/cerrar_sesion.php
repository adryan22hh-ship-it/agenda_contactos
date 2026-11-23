<?php

session_start();

// Destruir la sesión
session_destroy();

// Regresar al login
header("Location: login.php");
exit();

?>