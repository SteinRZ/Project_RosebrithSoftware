<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar Cambios Empleado</title>
</head>
<body>

<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include("..\php\db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $id_empleado = $_POST['ID_Empleado'];
    $area = $_POST['Area'];
    $telefono = $_POST['Telefono'];
    $Sueldo = $_POST['Sueldo'];

    // Actualiza la tabla Empleado
    $sql_update = "UPDATE Empleado SET Area='$area', Telefono='$telefono', Sueldo='$Sueldo' WHERE ID_Empleado=$id_empleado";
    if ($conn->query($sql_update) === TRUE) {
        echo "Cambios guardados exitosamente (Empleado).";
    } else {
        echo "Error al guardar cambios (Empleado): " . $conn->error;
    }
}

// CERRAR CONEXION
$conn->close();
?>

<!-- Botón de Regresar -->
<a href="../html/admin_page.php">Regresar</a>

</body>
</html>
