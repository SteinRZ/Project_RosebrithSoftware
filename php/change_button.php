<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id_usuario'])) {
    // Si está en sesión, muestra el botón "Perfil" y "Cerrar sesión"
    echo '
    <nav>
        <ul class="nav__links">
            <li><a href="client_page.php">Perfil</a></li>
        </ul>
    </nav>
    ';
    echo '<a class="navbar__button" href="../php/logout.php"><button>Cerrar sesión</button></a>';
} else {
    // Si no está en sesión, muestra el botón para iniciar sesión
    echo '<a class="navbar__button" href="../html/login.php"><button>Iniciar sesión</button></a>';
}
?>
