<?php
session_start();
session_destroy();
header("Location: ../html/login.php"); // Redirige a la página de inicio de sesión (o cualquier otra página)
exit();
?>
