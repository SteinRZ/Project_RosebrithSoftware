<?php
session_start();
include 'db_config.php';
require ('../fpdf186/fpdf.php');

// Función para generar el reporte de las gráficas
function generarReporteGraficas() {
    // Creamos un nuevo objeto FPDF
    $pdf = new FPDF('P','mm','A4');
    $pdf->AddPage();

    // Agregamos el encabezado del PDF
    // Aquí puedes personalizar el encabezado como desees
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 0, 'REPORTE RESERVACIONES', 0, 1, 'C');
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
    // Agrega más información si lo deseas, como fecha, nombre del usuario, etc.

    // Agregamos las gráficas al PDF
    // Aquí deberías incluir el código para generar las gráficas según tu implementación
    
    // Finalmente, generamos el PDF
    $pdf->Output();
}

// Llamamos a la función para generar el reporte de las gráficas
generarReporteGraficas();
?>