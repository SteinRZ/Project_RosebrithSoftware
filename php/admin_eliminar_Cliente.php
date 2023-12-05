<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['Cliente'];

    // Verificar si el ID es válido y no está vacío
    if (!empty($id_cliente) && is_numeric($id_cliente)) {
        // Verificar dependencias en la tabla 'reservacion'
        $sql_check_reservaciones = "SELECT * FROM Reservacion WHERE ID_Cliente = $id_cliente";

        $result_reservaciones = $conn->query($sql_check_reservaciones);

        if ($result_reservaciones->num_rows > 0) {
            // Si hay dependencias en 'reservacion', mostrar una alerta
            echo "<script>
                alert('No se puede eliminar el cliente debido a reservaciones asociadas.');
                window.location.href='../php/admin_table_client.php';
              </script>";
        } else {
            // No hay dependencias, proceder con la eliminación del cliente
            $sql_delete_cliente = "DELETE FROM Cliente WHERE ID_Cliente = $id_cliente";

            if ($conn->query($sql_delete_cliente) === TRUE) {
                // Cliente eliminado correctamente
                echo "<script>
                    alert('Cliente eliminado correctamente.');
                    window.location.href='../php/admin_table_client.php';
                  </script>";
            } else {
                // Error al eliminar el cliente
                echo "<script>
                    alert('Error al eliminar el cliente.');
                    window.location.href='../php/admin_table_client.php';
                  </script>";
            }
        }
    } else {
        // ID de cliente no válido
        echo "<script>
            alert('ID de cliente no válido.');
            window.location.href='../php/admin_table_client.php';
          </script>";
    }
}
// CERRAR CONEXION
$conn->close();
?>