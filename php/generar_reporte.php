<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

// OBTENCION DE ELEMENTO DE COMBOBOX
if (isset($_POST['reporte'])) {
    $tipoReserva = $_POST['opciones'];
    obtenerReservaciones($tipoReserva);
}

function obtenerReservaciones($tipoReserva) {
    // Obtener la fecha actual
    $fechaActual = date('Y-m-d');

    // Preparar la consulta SQL
    $stmt = $mysqli->prepare("SELECT Fecha_Reserva, Tipo_Reserva, Anticipo, Duracion, Total FROM Reservacion WHERE Fecha_Reserva > ? AND Tipo_Reserva = ?");
    $stmt->bind_param('ss', $fechaActual, $tipoReserva);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();

    // Mostrar los resultados
    while ($row = $result->fetch_assoc()) {
        echo 'Fecha de Reserva: ' . $row['Fecha_Reserva'] . ', Tipo de Reserva: ' . $row['Tipo_Reserva'] . ', Anticipo: ' . $row['Anticipo'] . ', Duración: ' . $row['Duracion'] . ', Total: ' . $row['Total'] . '<br>';
    }
}