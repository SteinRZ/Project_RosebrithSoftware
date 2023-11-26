<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar Cambios Cliente</title>
</head>
<body>

<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include ("../php/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['ID'];

    // Verifica la tabla y ejecuta la consulta DELETE correspondiente
    if (isset($_POST['ID_Empleado'])) {
        $sql_delete = "DELETE FROM Empleado WHERE ID_Empleado = $id";
    } elseif (isset($_POST['ID_Cliente'])) {
        $sql_delete = "DELETE FROM Cliente WHERE ID_Cliente = $id";
    } elseif (isset($_POST['ID_Reservacion'])) {
        $sql_delete = "DELETE FROM Reservacion WHERE ID_Reservacion = $id";
    }

    // Ejecuta la consulta
    if ($conn->query($sql_delete) === TRUE) {
        echo "Registro eliminado correctamente.";
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
}

// CERRAR CONEXION
$conn->close();
?>

<!-- Botón de Regresar -->
<a href="../html/admin_page.php">Regresar</a>

</body>
</html>