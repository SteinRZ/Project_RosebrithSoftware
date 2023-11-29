<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar Cambios Cliente</title>
</head>
<body>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// CONFIGURACION DE LA BASE DE DATOS
include ("../php/db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $area = $_POST['area'];
    $telefono = $_POST['telefono'];
    $sueldo = $_POST['sueldo'];

    // Consulta preparada para prevenir inyecciones SQL
    $sql_insert = $conn->prepare("INSERT INTO Empleado (ID_Usuario, Area, Telefono, Sueldo) VALUES (?, ?, ?, ?)");
    $sql_insert->bind_param("sssd", $id_usuario, $area, $telefono, $sueldo);

    if ($sql_insert->execute()) {
        echo "Empleado registrado correctamente.";
    } else {
        echo "Error al registrar empleado: " . $sql_insert->error;
    }

    // Cerrar la consulta preparada
    $sql_insert->close();
}

// CERRAR CONEXION
$conn->close();
?>

<!-- Botón de Regresar -->
<a href="../html/admin_page.php">Regresar</a>

</body>
</html>