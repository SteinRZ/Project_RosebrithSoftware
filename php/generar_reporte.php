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

    // Establecer el color del borde y el fondo del recuadro
    $pdf->SetDrawColor(0); // Establecer color de borde a negro (RGB: 0,0,0)
    $pdf->SetFillColor(255); // Establecer color de fondo a blanco (RGB: 255,255,255)

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 0, 'REPORTE DE RESERVACIONES', 0, 1, 'C');


    // Dibujar un recuadro con borde negro y fondo blanco
    $pdf->Rect(10, 20, 190, 30, 'D'); // Coordenadas (x, y, ancho, alto)

    // Establecer el color del texto
    $pdf->SetTextColor(0); // Establecer color del texto a negro

    // Agregar el texto dentro del recuadro
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text(15, 26, 'Alberca RoseBrith');

    // Obtener el correo del usuario autenticado
    $correoUsuarioGenerador = isset($_SESSION['correo_usuario']) ? $_SESSION['correo_usuario'] : 'Correo no disponible';

    // Establecer la zona horaria a "America/Mexico_City"
    date_default_timezone_set('America/Matamoros');

    $pdf->SetFont('Arial', '', 10);
    $pdf->Text(15, 33, 'Union del Recuerdo, Calle Recuerdo Ave. La Cruz #812');
    $pdf->Text(15, 37, 'Nuevo Laredo Tamaulipas (867)-29-99-78');
    $pdf->Text(15, 41, 'Fecha del Reporte: ' . date('Y-m-d H:i:s'));
    $pdf->Text(15, 45, 'Generado por: ' . $correoUsuarioGenerador);
    $pdf->SetFont('Arial', '', 10);



    // Agregar el logo dentro del recuadro
    $pdf->Image('../image/main_icon.png', 170, 23, 25);

    // Salto de línea después del recuadro
    $pdf->Ln(50); // Puedes ajustar esta distancia según sea necesario

    // Configurar la fuente
    $pdf->SetFont('Arial', 'B', 16);

    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(53, 105, 116); // Color Azul Verdoso
    $pdf->SetTextColor(255);
    $pdf->Cell(30, 10, 'Nombre cliente', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Fecha de reserva', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Tipo de reserva', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Anticipo', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Duracion', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Total', 1, 0, 'C', true);
    $pdf->Ln();

    // Obtener la fecha actual
    $fechaActual = date('Y-m-d');

    // Preparar la consulta SQL
    $stmt = $conn->prepare("SELECT c.Nombre AS Nombre_Cliente, r.Fecha_Reserva, r.Tipo_Reserva, r.Anticipo, r.Duracion, r.Total FROM Reservacion r INNER JOIN Cliente c ON r.ID_Cliente = c.ID_Cliente WHERE r.Fecha_Reserva < ? AND r.Tipo_Reserva = ?");
    $stmt->bind_param('ss', $fechaActual, $tipoReserva);



    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();

    // Restaurar color de texto
    $pdf->SetTextColor(0);

    // Mostrar los resultados
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
    
    // Guardar el PDF
    $pdf->Output();
}

function obtenerReservacionesAnteriores($tipoReserva) {
    global $conn;

    // Crear una instancia de la clase FPDF
    $pdf = new FPDF('P','mm','A4');
    $pdf->AddPage();

   
    // Establecer el color del borde y el fondo del recuadro
    $pdf->SetDrawColor(0); // Establecer color de borde a negro (RGB: 0,0,0)
    $pdf->SetFillColor(255); // Establecer color de fondo a blanco (RGB: 255,255,255)

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 0, 'REPORTE DE RESERVACIONES', 0, 1, 'C');


    // Dibujar un recuadro con borde negro y fondo blanco
    $pdf->Rect(10, 20, 190, 30, 'D'); // Coordenadas (x, y, ancho, alto)

    // Establecer el color del texto
    $pdf->SetTextColor(0); // Establecer color del texto a negro

    // Agregar el texto dentro del recuadro
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text(15, 28, 'Alberca RoseBrith');

    $pdf->SetFont('Arial', '', 10);
    $pdf->Text(15, 35, 'Union del Recuerdo, Calle Recuerdo Ave. La Cruz #812');
    $pdf->Text(15, 40, 'Nuevo Laredo Tamaulipas (867)-29-99-78');
    $pdf->Text(15, 45, 'Fecha del Reporte: ' . date('Y-m-d H:i:s'));


    // Agregar el logo dentro del recuadro
    $pdf->Image('../image/main_icon.png', 170, 23, 25);

    // Salto de línea después del recuadro
    $pdf->Ln(50); // Puedes ajustar esta distancia según sea necesario

    // Configurar la fuente
    $pdf->SetFont('Arial', 'B', 16);


    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(53, 105, 116); // Color Azul Verdoso
    $pdf->SetTextColor(255);
    $pdf->Cell(30, 10, 'Nombre cliente', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Fecha de reserva', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Tipo de reserva', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Anticipo', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Duracion', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Total', 1, 0, 'C', true);
    $pdf->Ln();

    // Obtener la fecha actual
    $fechaActual = date('Y-m-d');

    $stmt = $conn->prepare("SELECT c.Nombre AS Nombre_Cliente, r.Fecha_Reserva, r.Tipo_Reserva, r.Anticipo, r.Duracion, r.Total FROM Reservacion r INNER JOIN Cliente c ON r.ID_Cliente = c.ID_Cliente WHERE r.Fecha_Reserva < ? AND r.Tipo_Reserva = ?");
    $stmt->bind_param('ss', $fechaActual, $tipoReserva);


    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();

    // Restaurar color de texto
    $pdf->SetTextColor(0);

    // Mostrar los resultados
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

    // Guardar el PDF
    $pdf->Output();
}
?>
