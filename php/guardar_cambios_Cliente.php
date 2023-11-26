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
include("..\php\db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario para Cliente
    $id_cliente = $_POST['ID_Cliente'];
    $telefono = $_POST['Telefono'];
    $deuda = $_POST['Deuda'];

    // Actualiza la tabla Cliente
    $sql_update_cliente = "UPDATE Cliente SET Telefono='$telefono', Deuda='$deuda' WHERE ID_Cliente=$id_cliente";
    if ($conn->query($sql_update_cliente) === TRUE) {
        echo "Cambios guardados exitosamente (Cliente).";
    } else {
        echo "Error al guardar cambios (Cliente): " . $conn->error;
    }
}

// CERRAR CONEXION
$conn->close();
?>

<!-- Botón de Regresar -->
<a href="../html/admin_page.php">Regresar</a>

</body>
</html>

