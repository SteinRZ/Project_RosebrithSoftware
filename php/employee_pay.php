<?php
// Iniciar sesión si no está activa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include 'db_config.php'; // Archivo de configuración de la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pagar_cita'])) {
    $id_reservacion = $_POST['id_reservacion'];
    $pagar = $_POST['pagar'];

    // Obtener el total actual y el total cambiado
    $query_total = "SELECT Total, TotalCambiado FROM reservacion WHERE ID_Reservacion = $id_reservacion";
    $result_total = $conn->query($query_total);

    if ($result_total->num_rows > 0) {
        $row = $result_total->fetch_assoc();
        $total = $row['Total'];
        $total_cambiado = $row['TotalCambiado'];

        if ($total_cambiado == 0) {
            // Mostrar una alerta indicando que ya está pagado
            echo "<script>
                    alert('Esta reservación ya ha sido completamente pagada.');
                    window.location.href='../html/employee_page.php';
                </script>";
            exit();
        }

        // Restar el monto pagado a TotalCambiado
        $total_cambiado -= $pagar;

    /*     // Si el monto pagado es mayor o igual al TotalCambiado, establecer TotalCambiado a 0
        if ($pagar >= $total_cambiado) {
            $total_cambiado = 0;
        } */

        if ($total_cambiado <= 0) {
            $total_cambiado = 0;
        }

        // Actualizar el TotalCambiado en la base de datos
        $sql_actualizar_total_cambiado = "UPDATE reservacion SET TotalCambiado = $total_cambiado WHERE ID_Reservacion = $id_reservacion";

        if ($conn->query($sql_actualizar_total_cambiado) === TRUE) {
            echo "<script>
                    alert('Se ha pagado correctamente.');
                    window.location.href='../html/employee_page.php';
                </script>";
            exit();
        } else {
            echo "Error al actualizar el TotalCambiado: " . $conn->error;
        }
    } else {
        echo "No se encontraron resultados para la reservación con ID: $id_reservacion";
    }
}
$conn->close(); // Cerrar la conexión a la base de datos
?>