<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar Cambios Reservación</title>
</head>
<body>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// CONFIGURACION DE LA BASE DE DATOS
include("..\php\db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario para Reservacion
    $id_reservacion = $_POST['ID_Reservacion'];
    $fecha_reserva = $_POST['Fecha_Reserva'];
    $tipo_reserva = $_POST['Tipo_Reserva'];
    $anticipo = $_POST['Anticipo'];
    $comentario = $_POST['Comentario'];

    // Actualiza la tabla Reservacion
    $sql_update_reservacion = "UPDATE Reservacion SET Fecha_Reserva='$fecha_reserva', Tipo_Reserva='$tipo_reserva', Anticipo='$anticipo', Comentario='$comentario' WHERE ID_Reservacion=$id_reservacion";
    if ($conn->query($sql_update_reservacion) === TRUE) {
        echo "<script>
        alert('Se han guardado los cambios de la Reservación con exito.');
        window.location.href='../html/admin_page.php';
      </script>";
    } else {
        echo "<script>
        alert('Error al guardar los de la Reservación cambios.');
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
