<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar Cambios Reservación</title>
</head>
<body>

<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include("..\php\db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario para Reservacion
    $Id_usuario = $_POST['ID_Usuario'];
    $Nombre = $_POST['Nombre'];
    $Apellido_Paterno = $_POST['Apellido_Paterno'];
    $Apellido_Materno = $_POST['Apellido_Materno'];
    $Correo = $_POST['Correo'];
    $Contraseña = $_POST['Contraseña'];
    $Rol = $_POST['Rol'];

    // Actualiza la tabla Reservacion
    $sql_update_usuario = "UPDATE usuario SET Nombre='$Nombre', Apellido_Paterno='$Apellido_Paterno', Apellido_Materno='$Apellido_Materno', Correo='$Correo', Contraseña='$Contraseña',Rol='$Rol' WHERE ID_Usuario=$Id_usuario";
    if ($conn->query($sql_update_usuario) === TRUE) {
        echo "<script>
        alert('Se han guardado los cambios del usuario con exito.');
        window.location.href='../html/admin_page.php';
      </script>";
    } else {
        echo "<script>
        alert('Error al guardar los cambios del usuario.');
        window.location.href='../html/admin_page.php';
      </script>" . $conn->error;
    }
}

// CERRAR CONEXION
$conn->close();
?>

<!-- Botón de Regresar -->
<a href="../html/admin_page.php">Regresar</a>

</body>
</html>
