<?php
session_start();
include 'db_config.php';
require ('../fpdf186/fpdf.php');

// OBTENCION DE ELEMENTO DE COMBOBOX
if (isset($_POST['reporte'])) {
    $tipoReserva = $_POST['opciones'];
    if(isset($_POST['reservaciones_anteriores']) && $_POST['reservaciones_anteriores'] == 'on') {
        obtenerReservacionesAnteriores($tipoReserva);
    } else {
        obtenerReservaciones($tipoReserva);
    }
}

function obtenerReservaciones($tipoReserva) {
    global $conn;

    // Crear una instancia de la clase FPDF
    $pdf = new FPDF('P','mm','A4');
    $pdf->AddPage();

    // Configurar la fuente
    $pdf->SetFont('Arial', 'B', 16);

    // Agregar el encabezado
    $pdf->Cell(0, 10, 'Rosebrith', 0, 0, 'L');

    // Agregar el logo
    $pdf->Image('../image/main_icon.png',160,10,25);
    $pdf->Ln(20);

    // Agregar el subtítulo
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Reporte del sistema de renta de alberca y salon', 0, 0, 'L');
    $pdf->Ln(20);

    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, '# de cliente', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Fecha de reserva', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Tipo de reserva', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Anticipo', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Duracion', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Total', 1, 0, 'C');
    $pdf->Ln();

    // Obtener la fecha actual
    $fechaActual = date('Y-m-d');

    // Preparar la consulta SQL
    $stmt = $conn->prepare("SELECT ID_Cliente, Fecha_Reserva, Tipo_Reserva, Anticipo, Duracion, Total FROM Reservacion WHERE Fecha_Reserva > ? AND Tipo_Reserva = ?");
    $stmt->bind_param('ss', $fechaActual, $tipoReserva);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();

    // Mostrar los resultados
    $pdf->SetFont('Arial', '', 10);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['ID_Cliente'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['Fecha_Reserva'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Tipo_Reserva'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Anticipo'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Duracion'] . ' hora(s)', 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Total'], 1, 0, 'C');
        $pdf->Ln();
    }

    // Guardar el PDF
    $pdf->Output();
}

function obtenerReservacionesAnteriores($tipoReserva) {
    global $conn;

    // Crear una instancia de la clase FPDF
    $pdf = new FPDF('P','mm','A4');
    $pdf->AddPage();

    // Configurar la fuente
    $pdf->SetFont('Arial', 'B', 16);

    // Agregar el encabezado
    $pdf->Cell(0, 10, 'Rosebrith', 0, 0, 'L');

    // Agregar el logo
    $pdf->Image('../image/main_icon.png',160,10,25);
    $pdf->Ln(20);

    // Agregar el subtítulo
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Reporte del sistema de renta de alberca y salon', 0, 0, 'L');
    $pdf->Ln(20);

    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, '# de cliente', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Fecha de reserva', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Tipo de reserva', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Anticipo', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Duracion', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Total', 1, 0, 'C');
    $pdf->Ln();

    // Obtener la fecha actual
    $fechaActual = date('Y-m-d');

    // Preparar la consulta SQL
    $stmt = $conn->prepare("SELECT ID_Cliente, Fecha_Reserva, Tipo_Reserva, Anticipo, Duracion, Total FROM Reservacion WHERE Fecha_Reserva < ? AND Tipo_Reserva = ?");
    $stmt->bind_param('ss', $fechaActual, $tipoReserva);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();

    // Mostrar los resultados
    $pdf->SetFont('Arial', '', 10);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['ID_Cliente'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['Fecha_Reserva'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Tipo_Reserva'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Anticipo'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Duracion'] . ' hora(s)', 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Total'], 1, 0, 'C');
        $pdf->Ln();
    }

    // Guardar el PDF
    $pdf->Output();
}
?>