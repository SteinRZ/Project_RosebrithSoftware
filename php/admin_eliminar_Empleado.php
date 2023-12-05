<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Empleado'])) {
    $id_empleado = $_POST['Empleado'];

    // Eliminar empleado
    $sql_delete = "DELETE FROM Empleado WHERE ID_Empleado = $id_empleado";

    // Ejecutar la consulta de eliminación
    if ($conn->query($sql_delete) === TRUE) {
        // Redirigir después de eliminar el registro
        echo "<script>
            alert('Empleado eliminado con éxito.');
            window.location.href='../php/admin_table_employee.php';
        </script>";
        exit;
    } else {
        // Si hay un error al eliminar, muestra un mensaje y redirige
        echo "<script>
            alert('Error al eliminar el empleado: " . $conn->error . "');
            window.location.href='../php/admin_table_employee.php';
        </script>";
        exit;
    }
}
// CERRAR CONEXION
$conn->close();
?>