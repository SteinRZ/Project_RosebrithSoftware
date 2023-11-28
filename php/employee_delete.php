<?php
session_start();

// Verificar si se envió la solicitud de eliminación de reservación
if (isset($_POST['delete_reservation'])) {
    include 'db_config.php'; // Incluir la configuración de la base de datos

    // Obtener el ID de la reservación a eliminar
    $id_reservacion_a_eliminar = $_POST['id_reservacion']; // Asegúrate de que esté correctamente pasado por POST

    // Definir consultas DELETE para eliminar datos relacionados
    $sql_eliminar_eventos = "DELETE FROM evento WHERE ID_Reservacion = '$id_reservacion_a_eliminar'";
    $sql_eliminar_reservacion = "DELETE FROM reservacion WHERE ID_Reservacion = '$id_reservacion_a_eliminar'";

    // Ejecutar las consultas en una transacción para asegurar la integridad de los datos
    $conn->begin_transaction();

    try {
        // Eliminar eventos asociados a la reservación
        $conn->query($sql_eliminar_eventos);

        // Eliminar la reservación
        $conn->query($sql_eliminar_reservacion);

        // Confirmar las consultas si no hay errores
        $conn->commit();

        // Mostrar un mensaje de éxito utilizando JavaScript
        echo "<script>
                alert('Reservación eliminada exitosamente');
                window.location.href = '../html/employee_page.php'; // Redirigir a la página deseada
              </script>";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();

        // Mostrar un mensaje de error en caso de fallo
        echo "<script>
                alert('Error al eliminar la reservación: " . $e->getMessage() . "');
                window.location.href = '../html/employee_page.php'; // Redirigir a la página deseada
              </script>";
    }

    // Cerrar la conexión
    $conn->close();
}
?>