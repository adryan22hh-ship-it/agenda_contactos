
<nav>
    <h2>Agenda Personal</h2>

    <div>
        <?php if (isset($_SESSION['id_usuario'])) { ?>

            <a href="/dashboard/index.php">Inicio</a>

            <a href="/contactos/listar.php">Contactos</a>

            <a href="/usuarios/cerrar_sesion.php">Cerrar sesión</a>

        <?php } else { ?>

            <a href="/usuarios/login.php">Iniciar sesión</a>

            <a href="/usuarios/registro.php">Registrarse</a>

        <?php } ?>
    </div>
</nav>
