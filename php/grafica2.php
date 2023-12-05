<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// CONFIGURACION DE LA BASE DE DATOS
include ("..\php\db_config.php");

// Función para obtener datos filtrados por fecha
function filterDataByDate($dataArray, $date) {
    $filteredData = [];
    foreach ($dataArray as $key => $value) {
        if ($key == $date) {
            $filteredData[$key] = $value;
        }
    }
    return $filteredData;
}

// Funciones de filtrado
function filterDataDay($originalData) {
    $currentDate = date('Y-m-d');
    return filterDataByDate($originalData, $currentDate);
}

function filterDataWeek($originalData) {
    $currentDate = date('Y-m-d');
    $startOfWeek = date('Y-m-d', strtotime('last Monday', strtotime($currentDate)));
    $endOfWeek = date('Y-m-d', strtotime('next Sunday', strtotime($currentDate)));

    $filteredData = [];
    foreach ($originalData as $key => $value) {
        if ($key >= $startOfWeek && $key <= $endOfWeek) {
            $filteredData[$key] = $value;
        }
    }

    return $filteredData;
}

function filterDataMonth($originalData) {
    $currentMonth = date('Y-m');
    // Implementa la lógica para filtrar por mes
    // Ajusta según tu estructura de datos y formato de fechas
    return $originalData; // Actualmente no implementado, devolver originalData
}

function filterDataCustom($originalData, $customDate) {
    // Implementa la lógica para filtrar por fecha personalizada
    // Ajusta según tu estructura de datos y formato de fechas
    return filterDataByDate($originalData, $customDate);
}

// Consultas SQL para obtener datos
$sqlReservaciones = "SELECT Fecha_Creacion, Tipo_Reserva, COUNT(*) as total FROM Reservacion GROUP BY Fecha_Creacion, Tipo_Reserva";
$resultReservaciones = $conn->query($sqlReservaciones);

// Obtener datos para los gráficos
$originalReservacionesData = [];

while ($row = $resultReservaciones->fetch_assoc()) {
    $originalReservacionesData[$row['Fecha_Creacion']][$row['Tipo_Reserva']] = $row['total'];
}

// Lógica de filtrado según la opción seleccionada
$filterType = isset($_POST['filterType']) ? $_POST['filterType'] : 'day';

switch ($filterType) {
    case 'day':
        $currentReservacionesData = filterDataDay($originalReservacionesData);
        break;
    case 'week':
        $currentReservacionesData = filterDataWeek($originalReservacionesData);
        break;
    case 'month':
        $currentReservacionesData = filterDataMonth($originalReservacionesData);
        break;
    case 'custom':
        $customDate = isset($_POST['selectedDate']) ? $_POST['selectedDate'] : date('Y-m-d');
        $currentReservacionesData = filterDataCustom($originalReservacionesData, $customDate);
        break;
    default:
        // Por defecto, filtra por día
        $currentReservacionesData = filterDataDay($originalReservacionesData);
        break;
}

// Obtener etiquetas y conjuntos de datos ordenados cronológicamente
$sortedLabels = array_keys($currentReservacionesData);
sort($sortedLabels);

$datasets = [];
$tiposReservacion = [];

// Iterar sobre las etiquetas ordenadas
foreach ($sortedLabels as $date) {
    // Obtener tipos únicos de reservaciones
    $tiposReservacion = array_unique(array_merge($tiposReservacion, array_keys($currentReservacionesData[$date])));
}

// Crear un conjunto de datos para cada tipo de reservación
foreach ($tiposReservacion as $tipo) {
    $data = [];
    foreach ($sortedLabels as $date) {
        $data[] = $currentReservacionesData[$date][$tipo] ?? 0;
    }

    $datasets[] = [
        'label' => $tipo,
        'data' => $data,
        'backgroundColor' => getBackgroundColor($tipo),
        'borderColor' => getBorderColor($tipo),
        'borderWidth' => 1
    ];
}

// Funciones para obtener colores según el tipo de reservación
function getBackgroundColor($tipo) {
    switch ($tipo) {
        case 'Salon':
            return 'rgba(75, 192, 192, 0.2)';
        case 'Alberca':
            return 'rgba(255, 99, 132, 0.2)';
        case 'Ambos':
            return 'rgba(255, 205, 86, 0.2)';
        default:
            return 'rgba(0, 0, 0, 0.2)';
    }
}

function getBorderColor($tipo) {
    switch ($tipo) {
        case 'Salon':
            return 'rgba(75, 192, 192, 1)';
        case 'Alberca':
            return 'rgba(255, 99, 132, 1)';
        case 'Ambos':
            return 'rgba(255, 205, 86, 1)';
        default:
            return 'rgba(0, 0, 0, 1)';
    }
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosebrith | Estadísticas</title>
    <!-- Tus enlaces CSS y otros metadatos -->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Tus estilos CSS aquí */
    </style>
</head>
<body>

<!-- Controles de filtrado -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="filterType">Seleccionar:</label>
    <select id="filterType" name="filterType">
        <option value="day">Día</option>
        <option value="week">Semana</option>
        <option value="month">Mes</option>
        <option value="custom">Personalizado</option>
    </select>
    
    <div id="dateControls" style="display: none;">
        <label for="selectedDate">Fecha:</label>
        <input type="date" id="selectedDate" name="selectedDate">
    </div>

    <input type="submit" value="Filtrar">
</form>

<!-- Gráfico de barras para reservaciones por tipo y fecha de reserva -->
<canvas id="reservacionesChart" width="300" height="100"></canvas>

<!-- Scrit para grafica fecha reserva -->
<script>
    // Datos para el gráfico de reservaciones
    var reservacionesData = {
        labels: <?php echo json_encode($sortedLabels); ?>,
        datasets: <?php echo json_encode($datasets); ?>
    };

    // Función para crear el gráfico de barras
    function createChart(canvasId, chartData) {
        var ctx = document.getElementById(canvasId).getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: chartData.datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: true
                    },
                    x: {
                        stacked: true
                    }
                }
            }
        });
    }

    // Crear gráfico
    createChart('reservacionesChart', reservacionesData);

    // Lógica para mostrar/ocultar controles de fecha
    $(document).ready(function () {
        $('#filterType').change(function () {
            if ($(this).val() == 'custom') {
                $('#dateControls').show();
            } else {
                $('#dateControls').hide();
            }
        });
    });
</script>

<!-- Script para fecha creacion -->


<!-- ... Resto de tu código JavaScript y HTML ... -->

</body>
</html>
