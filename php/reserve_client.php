<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db_config.php'; // Archivo de configuración de la base de datos

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];

    // Obtener otros datos del formulario o de donde sea que estén disponibles
    $tipo_reserva = $_POST['tipo_reserva'];
    $fecha_reservacion = $_POST['fecha_reservacion'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_final = $_POST['hora_final'];
    $anticipo = $_POST['anticipo'];

    // Buscar al empleado con el 'Area' igual al 'Tipo de Reserva'
    $sql_empleado = "SELECT ID_Empleado FROM empleado WHERE Area = '$tipo_reserva'";
    $result_empleado = $conn->query($sql_empleado);

    if ($result_empleado->num_rows > 0) {
        $row = $result_empleado->fetch_assoc();
        $ID_Empleado = $row['ID_Empleado'];

        // Comenzar la transacción
        $conn->begin_transaction();

        // Insertar en la tabla reservacion
        $sql_reservacion = "INSERT INTO reservacion (ID_Cliente, Fecha_Reserva, Tipo_Reserva, Anticipo) 
                            VALUES ('$id_usuario', '$fecha_reservacion', '$tipo_reserva', '$anticipo')";

        if ($conn->query($sql_reservacion) === TRUE) {
            $ID_Reservacion = $conn->insert_id; // Obtener el ID de la última reservación insertada

            // Insertar en la tabla evento
            $sql_evento = "INSERT INTO evento (ID_Reservacion, ID_Empleado, Hora_Inicio, Hora_Final) 
                           VALUES ('$ID_Reservacion', '$ID_Empleado', '$hora_inicio', '$hora_final')";

            if ($conn->query($sql_evento) === TRUE) {
                $conn->commit(); // Confirmar la transacción si ambos INSERT son exitosos
                echo "<script>
                        alert('Reserva realizada con éxito.');
                        window.location.href='../html/client_page.php';
                    </script>";
            } else {
                $conn->rollback(); // Revertir la transacción si hay error en el segundo INSERT
                echo "Error al insertar evento: " . $conn->error;
            }
        } else {
            $conn->rollback(); // Revertir la transacción si hay error en el primer INSERT
            echo "Error al insertar reservación: " . $conn->error;
        }
    } else {
        echo "No se encontró un empleado con el Área correspondiente al Tipo de Reserva.";
    }
} else {
    echo "<script>alert('No se ha iniciado sesión, para realizar una reserva necesitas iniciar sesión.');
    window.location.href='../html/login.php';</script>";
}

$conn->close(); // Cerrar la conexión a la base de datos
?>
