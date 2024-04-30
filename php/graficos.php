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


$selected_year = isset($_POST['selected_year']) ? $_POST['selected_year'] : date("Y");

// Consulta SQL para saber si están pagados filtrando por mes y año
$sqlReservaciones2 = "SELECT 
    SUM(CASE WHEN TotalCambiado = 0 THEN 1 ELSE 0 END) AS pagados,
    SUM(CASE WHEN TotalCambiado != 0 THEN 1 ELSE 0 END) AS noPagados
FROM Reservacion
WHERE YEAR(Fecha_Reserva) = '$selected_year'";

$resultReservaciones2 = $conn->query($sqlReservaciones2);

// Verificar si la consulta se ejecutó correctamente
if ($resultReservaciones2) {
    // Inicializar el array para almacenar los datos
    $originalReservacionesData2 = [];

    // Obtener los resultados de la consulta
    while ($row2 = $resultReservaciones2->fetch_assoc()) {
        // Almacenar los datos en el array
       
        $noPagados = $row2['noPagados'];
        $pagados = $row2['pagados'];

        // Agregar los datos al array
        $originalReservacionesData2[] = [
            'No_Pagados' => $noPagados,
            'Pagados' => $pagados
        ];
    }
} else {
    // Manejar el caso en que la consulta no se ejecute correctamente
    echo "Error al ejecutar la consulta.";
}
$selected_year2 = isset($_POST['selected_year']) ? $_POST['selected_year'] : date("Y");
//CONSULTA PARA GANANCIAS
$sqlReservaciones3 = "SELECT 
MONTH(Fecha_Reserva) AS Mes,
YEAR(Fecha_Reserva) AS Año,
SUM(Total - TotalCambiado) AS Ganancia
FROM Reservacion
WHERE YEAR(Fecha_Reserva) = '$selected_year2'
GROUP BY MONTH(Fecha_Reserva), YEAR(Fecha_Reserva)
ORDER BY MONTH(Fecha_Reserva)";

$resultReservaciones3 = $conn->query($sqlReservaciones3);

// Verificar si la consulta se ejecutó correctamente
if ($resultReservaciones3) {
    // Inicializar el array para almacenar los datos
    $originalReservacionesData3 = [];

    // Obtener los resultados de la consulta
    while ($row3 = $resultReservaciones3->fetch_assoc()) {
        // Almacenar los datos en el array
        $Mes = $row3['Mes'];
        $Año = $row3['Año'];
        $Ganancia = $row3['Ganancia'];

        // Agregar los datos al array
        $originalReservacionesData3[] = [
            'Mes' => $Mes,
            'Año' => $Año,
            'Ganancia' => $Ganancia
        ];
    }
} else {
    // Manejar el caso en que la consulta no se ejecute correctamente
    echo "Error al ejecutar la consulta.";
}


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
//PRUEBA
// Obtener etiquetas y conjuntos de datos ordenados cronológicamente
$pagadosData = array_column($originalReservacionesData2, 'Pagados');
$noPagadosData = array_column($originalReservacionesData2, 'No_Pagados');

// Crea un solo conjunto de datos combinado
$datasetsCombined = [
    [
        
        'data' => [$pagadosData, $noPagadosData], // Combina los totales de pagados y no pagados en un solo conjunto de datos
        'labels' => ['Pagados',"N"], // Etiquetas separadas para la leyenda
        'backgroundColor' => [
            'rgba(0, 128, 0, 0.2)', // Color de fondo para los datos de "Pagados" (verde fuerte)
            'rgba(255, 0, 0, 0.2)' // Color de fondo para los datos de "No Pagados" (rojo fuerte)
        ],
        'borderColor' => [
            'rgba(75, 192, 192, 1)', // Color de borde para los datos de "Pagados"
            'rgba(255, 99, 132, 1)' // Color de borde para los datos de "No Pagados"
        ],
        'borderWidth' => 1
    ]
];

// Asigna el nuevo conjunto de datos combinado
$datasets2 = $datasetsCombined;

//GANANCIAS
$mesData = array_column($originalReservacionesData3, 'Mes');
$añoData = array_column($originalReservacionesData3, 'Año');
$gananciaData = array_column($originalReservacionesData3, 'Ganancia');

// Etiquetas para la leyenda
$labels2 = [];
foreach ($mesData as $index => $mes) {
    $labels2[] = "$mes/$añoData[$index]"; // Formato: mes/año
}

// Crea un solo conjunto de datos combinado
$datasetsCombined2 = [
    [
    
        'label' => 'Ganancia', // Etiquetas para la leyenda
        'data' => $gananciaData,
        'backgroundColor' => [
            'rgba(0, 128, 0, 0.2)', // Color de fondo para los datos de "Ganancia" (verde fuerte)
        ],
        'borderColor' => [
            'rgba(75, 192, 192, 1)', // Color de borde para los datos de "Ganancia"
        ],
        'borderWidth' => 1
    ]
];

// Asigna el nuevo conjunto de datos combinado
$datasets3 = $datasetsCombined2;
$chartData = [
    'labels' => $labels2, // Etiquetas para el eje x
    'datasets' => $datasetsCombined2 // Conjuntos de datos para las barras
];
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
    <button onclick = "window.print()">imprimir</button>
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
<!-- Grafica de pagados y pendientes -->
<div id="legendTitle" style="text-align: center; margin-bottom: 10px;">
    <h3>Cantidad y tipos de usuarios</h3>
</div>



<!-- Scrit para grafica fecha reserva -->
<script>
    // Datos para el gráfico de reservaciones
    var reservacionesData = {
        labels: <?php echo json_encode($sortedLabels); ?>,
        datasets: <?php echo json_encode($datasets); ?>
    };

    var reservacionesData2 = {
        
        datasets: <?php echo json_encode($datasets2); ?>
    };

    var reservacionesData3 = {
        
        datasets: <?php echo json_encode($datasets3); ?>
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
                        stacked: true,
                        ticks:{
                            stepSize:1
                        }
                    },
                    x: {
                        stacked: true
                    }
                }
            }
        });
    }

      // Función para crear el gráfico de pastel
      function createChart2(canvasId, chartData) {
        var ctx = document.getElementById(canvasId).getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartData.labels,
                datasets: chartData.datasets
            },
            options: {
            aspectRatio: 1.5, // Relación de aspecto ajustada
            responsive: false,
            maintainAspectRatio: true,
              
                scales: {
                    y: {
                        display: false,
                        beginAtZero: true,
                        stacked: true
                    },
                    x: {
                        display: false,
                        stacked: true
                    }
                }
            }
        });
    }

    function createChart3(canvasId, chartData) {
    var ctx = document.getElementById(canvasId).getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels:  <?php echo json_encode($labels2); ?>,
            datasets: chartData.datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    display: true,
                    beginAtZero: true
                },
                x: {
                    display: true
                }
            }
        }
    });
}



    // Crear gráfico
    createChart('reservacionesChart', reservacionesData);
    createChart2('reservacionesChart2', reservacionesData2 );
    createChart3('reservacionesChart3', reservacionesData3);

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

