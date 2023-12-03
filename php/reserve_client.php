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

    // Comprobación de disponibilidad de la fecha y tipo de reserva
    $stmt_verificar_reserva = $conn->prepare("SELECT ID_Reservacion FROM reservacion WHERE Fecha_Reserva = ? AND Tipo_Reserva = ?");
    $stmt_verificar_reserva->bind_param("ss", $fecha_reservacion, $tipo_reserva);
    $stmt_verificar_reserva->execute();
    $result_verificar_reserva = $stmt_verificar_reserva->get_result();

    if ($result_verificar_reserva->num_rows > 0 && $tipo_reserva !== 'Ambos') {
        // Si ya existe una reserva para la fecha y tipo seleccionados y el tipo de reserva no es "Ambos", mostrar una alerta
        echo "<script>
                alert('No se puede realizar la reserva. La fecha o tipo de reserva ya está ocupada.');
                window.location.href='../html/reserve.php';
              </script>";
        exit();
    }

    // Buscar al empleado con el 'Area' igual al 'Tipo de Reserva'
    $sql_empleado = "SELECT ID_Empleado FROM empleado WHERE Area = ?";
    $stmt_empleado = $conn->prepare($sql_empleado);
    $stmt_empleado->bind_param("s", $tipo_reserva);
    $stmt_empleado->execute();
    $result_empleado = $stmt_empleado->get_result();

    if ($result_empleado->num_rows > 0) {
        $row = $result_empleado->fetch_assoc();
        $ID_Empleado = $row['ID_Empleado'];

        // Comenzar la transacción
        $conn->begin_transaction();

        // Insertar en la tabla reservacion
        $sql_reservacion = "INSERT INTO reservacion (ID_Cliente, Fecha_Reserva, Tipo_Reserva, Anticipo) 
                            VALUES (?, ?, ?, ?)";
        $stmt_reservacion = $conn->prepare($sql_reservacion);
        $stmt_reservacion->bind_param("isss", $id_usuario, $fecha_reservacion, $tipo_reserva, $anticipo);
        $stmt_reservacion->execute();
        $ID_Reservacion = $conn->insert_id; // Obtener el ID de la última reservación insertada

        // Calcular la duración en horas
        $hora_inicio_dt = strtotime($hora_inicio);
        $hora_final_dt = strtotime($hora_final);
        $duracion = round(($hora_final_dt - $hora_inicio_dt) / 3600); // Calcula la diferencia en horas

        // Insertar en la tabla evento con la duración calculada
        $sql_evento = "INSERT INTO evento (ID_Reservacion, ID_Empleado, Hora_Inicio, Hora_Final, Duracion) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmt_evento = $conn->prepare($sql_evento);
        $stmt_evento->bind_param("iisss", $ID_Reservacion, $ID_Empleado, $hora_inicio, $hora_final, $duracion);
        $stmt_evento->execute();

        $conn->commit(); // Confirmar la transacción si ambos INSERT son exitosos
        echo "<script>
                alert('Reserva realizada con éxito.');
                window.location.href='../html/client_page.php';
              </script>";
    } else {
        echo "No se encontró un empleado con el Área correspondiente al Tipo de Reserva.";
    }
} else {
    echo "<script>alert('No se ha iniciado sesión, para realizar una reserva necesitas iniciar sesión.');
    window.location.href='../html/login.php';</script>";
}

$conn->close(); // Cerrar la conexión a la base de datos
?>