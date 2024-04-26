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

// Función para generar el encabezado del PDF
function generarEncabezado($pdf) {
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 0, 'REPORTE DE RESERVACIONES', 0, 1, 'C');
    $pdf->Rect(10, 20, 190, 30, 'D');
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text(15, 26, 'Rosebrith');
    $correoUsuarioGenerador = isset($_SESSION['correo_usuario']) ? $_SESSION['correo_usuario'] : 'Correo no disponible';
    date_default_timezone_set('America/Matamoros');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Text(15, 33, 'Union del Recuerdo, Calle Recuerdo Ave. La Cruz #812');
    $pdf->Text(15, 37, 'Nuevo Laredo Tamaulipas (867)-29-99-78');
    $pdf->Text(15, 41, 'Fecha del Reporte: ' . date('Y-m-d H:i:s'));
    $pdf->Text(15, 45, 'Generado por: ' . $correoUsuarioGenerador);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Image('../image/main_icon.png', 170, 23, 25);
    $pdf->Ln(50);
}

// Función para obtener reservaciones
function obtenerReservaciones($tipoReserva) {
    global $conn;

    $pdf = new FPDF('P','mm','A4');
    $pdf->AddPage();

    $pdf->SetDrawColor(0);
    $pdf->SetFillColor(255);

    generarEncabezado($pdf);

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(53, 105, 116);
    $pdf->SetTextColor(255);
    $pdf->Cell(30, 10, 'Nombre cliente', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Fecha de reserva', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Tipo de reserva', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Anticipo', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Duracion', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Total', 1, 0, 'C', true);
    $pdf->Ln();

    $fechaActual = date('Y-m-d');

    $stmt = $conn->prepare("SELECT c.Nombre AS Nombre_Cliente, r.Fecha_Reserva, r.Tipo_Reserva, r.Anticipo, r.Duracion, r.Total FROM Reservacion r INNER JOIN Cliente c ON r.ID_Cliente = c.ID_Cliente WHERE r.Fecha_Reserva > ? AND r.Tipo_Reserva = ?");
    $stmt->bind_param('ss', $fechaActual, $tipoReserva);

    $stmt->execute();

    $result = $stmt->get_result();

    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial', '', 10);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['Nombre_Cliente'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['Fecha_Reserva'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Tipo_Reserva'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Anticipo'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Duracion'] . ' hora(s)', 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Total'], 1, 0, 'C');
        $pdf->Ln();
    }

    $pdf->Output();
}

// Función para obtener reservaciones anteriores
function obtenerReservacionesAnteriores($tipoReserva) {
    global $conn;

    $pdf = new FPDF('P','mm','A4');
    $pdf->AddPage();

    $pdf->SetDrawColor(0);
    $pdf->SetFillColor(255);

    generarEncabezado($pdf);

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(53, 105, 116);
    $pdf->SetTextColor(255);
    $pdf->Cell(30, 10, 'Nombre cliente', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Fecha de reserva', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Tipo de reserva', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Anticipo', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Duracion', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Total', 1, 0, 'C', true);
    $pdf->Ln();

    $fechaActual = date('Y-m-d');

    $stmt = $conn->prepare("SELECT c.Nombre AS Nombre_Cliente, r.Fecha_Reserva, r.Tipo_Reserva, r.Anticipo, r.Duracion, r.Total FROM Reservacion r INNER JOIN Cliente c ON r.ID_Cliente = c.ID_Cliente WHERE r.Fecha_Reserva < ? AND r.Tipo_Reserva = ?");
    $stmt->bind_param('ss', $fechaActual, $tipoReserva);

    $stmt->execute();

    $result = $stmt->get_result();

    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial', '', 10);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['Nombre_Cliente'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['Fecha_Reserva'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Tipo_Reserva'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Anticipo'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Duracion'] . ' hora(s)', 1, 0, 'C');
        $pdf->Cell(30, 10, $row['Total'], 1, 0, 'C');
        $pdf->Ln();
    }

    $pdf->Output();
}
?>
