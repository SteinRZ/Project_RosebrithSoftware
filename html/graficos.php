<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// CONFIGURACION DE LA BASE DE DATOS
include ("..\php\db_config.php");

// Funciones de filtrado
function filterDataByDate($dataArray, $date) {
    $filteredData = ['total' => 0]; // Inicializar el total en 0

    foreach ($dataArray as $key => $value) {
        if ($key == $date) {
            $filteredData[$key] = $value;
            $filteredData['total'] += $value;
        }
    }
    return $filteredData;
}

function filterDataDay($originalData, $selectedDate) {
    return filterDataByDate($originalData, $selectedDate);
}

function filterDataWeek($originalData, $selectedDate) {
    $selectedWeek = date('YW', strtotime($selectedDate));
    $filteredData = ['total' => 0]; // Inicializar el total en 0

    foreach ($originalData as $key => $value) {
        if (date('YW', strtotime($key)) == $selectedWeek) {
            $filteredData[$key] = $value;
            $filteredData['total'] += $value;
        }
    }
    return $filteredData;
}

function filterDataMonth($originalData, $selectedDate) {
    $selectedMonth = date('Y-m', strtotime($selectedDate));
    $filteredData = ['total' => 0]; // Inicializar el total en 0

    foreach ($originalData as $key => $value) {
        if (date('Y-m', strtotime($key)) == $selectedMonth) {
            $filteredData[$key] = $value;
            $filteredData['total'] += $value;
        }
    }
    return $filteredData;
}

// Consultas SQL para obtener datos
$sqlUsuarios = "SELECT Fecha_Creacion, COUNT(*) as total FROM Usuario GROUP BY Fecha_Creacion";
$sqlEmpleados = "SELECT Fecha_Creacion, COUNT(*) as total FROM Empleado GROUP BY Fecha_Creacion";
$sqlClientes = "SELECT Fecha_Creacion, COUNT(*) as total FROM Cliente GROUP BY Fecha_Creacion";
$sqlReservaciones = "SELECT Fecha_Creacion, COUNT(*) as total FROM Reservacion GROUP BY Fecha_Creacion";

$resultUsuarios = $conn->query($sqlUsuarios);
$resultEmpleados = $conn->query($sqlEmpleados);
$resultClientes = $conn->query($sqlClientes);
$resultReservaciones = $conn->query($sqlReservaciones);

// Obtener datos para los gráficos
$originalUsuariosData = [];
$originalEmpleadosData = [];
$originalClientesData = [];
$originalReservacionesData = [];

while ($row = $resultUsuarios->fetch_assoc()) {
    $originalUsuariosData[$row['Fecha_Creacion']] = $row['total'];
}

while ($row = $resultEmpleados->fetch_assoc()) {
    $originalEmpleadosData[$row['Fecha_Creacion']] = $row['total'];
}

while ($row = $resultClientes->fetch_assoc()) {
    $originalClientesData[$row['Fecha_Creacion']] = $row['total'];
}

while ($row = $resultReservaciones->fetch_assoc()) {
    $originalReservacionesData[$row['Fecha_Creacion']] = $row['total'];
}

// Ordenar datos cronológicamente
ksort($originalUsuariosData);
ksort($originalEmpleadosData);
ksort($originalClientesData);
ksort($originalReservacionesData);

// Lógica de filtrado según la opción seleccionada
$filterType = isset($_POST['filterType']) ? $_POST['filterType'] : 'day';
$selectedDate = isset($_POST['selectedDate']) ? $_POST['selectedDate'] : date('Y-m-d');

switch ($filterType) {
    case 'day':
        $currentUsuariosData = filterDataDay($originalUsuariosData, $selectedDate);
        $currentEmpleadosData = filterDataDay($originalEmpleadosData, $selectedDate);
        $currentClientesData = filterDataDay($originalClientesData, $selectedDate);
        $currentReservacionesData = filterDataDay($originalReservacionesData, $selectedDate);
        break;
    case 'week':
        $currentUsuariosData = filterDataWeek($originalUsuariosData, $selectedDate);
        $currentEmpleadosData = filterDataWeek($originalEmpleadosData, $selectedDate);
        $currentClientesData = filterDataWeek($originalClientesData, $selectedDate);
        $currentReservacionesData = filterDataWeek($originalReservacionesData, $selectedDate);
        break;
    case 'month':
        $currentUsuariosData = filterDataMonth($originalUsuariosData, $selectedDate);
        $currentEmpleadosData = filterDataMonth($originalEmpleadosData, $selectedDate);
        $currentClientesData = filterDataMonth($originalClientesData, $selectedDate);
        $currentReservacionesData = filterDataMonth($originalReservacionesData, $selectedDate);
        break;
    case 'custom':
        // Seleccionar la fecha personalizada
        $currentUsuariosData = filterDataDay($originalUsuariosData, $selectedDate);
        $currentEmpleadosData = filterDataDay($originalEmpleadosData, $selectedDate);
        $currentClientesData = filterDataDay($originalClientesData, $selectedDate);
        $currentReservacionesData = filterDataDay($originalReservacionesData, $selectedDate);
        break;
    default:
        // Por defecto, filtra por día
        $currentUsuariosData = filterDataDay($originalUsuariosData, $selectedDate);
        $currentEmpleadosData = filterDataDay($originalEmpleadosData, $selectedDate);
        $currentClientesData = filterDataDay($originalClientesData, $selectedDate);
        $currentReservacionesData = filterDataDay($originalReservacionesData, $selectedDate);
        break;
}
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
        <option value="day" <?php echo ($filterType == 'day') ? 'selected' : ''; ?>>Día</option>
        <option value="week" <?php echo ($filterType == 'week') ? 'selected' : ''; ?>>Semana</option>
        <option value="month" <?php echo ($filterType == 'month') ? 'selected' : ''; ?>>Mes</option>
        <option value="custom" <?php echo ($filterType == 'custom') ? 'selected' : ''; ?>>Personalizado</option>
    </select>

    <div id="dateControls" <?php echo ($filterType == 'custom') ? '' : 'style="display: none;"'; ?>>
        <label for="selectedDate">Fecha:</label>
        <input type="date" id="selectedDate" name="selectedDate" value="<?php echo $selectedDate; ?>">
    </div>

    <input type="submit" value="Filtrar">
</form>

<!-- Gráfico de barras para usuarios -->
<canvas id="usuariosChart" width="300" height="100"></canvas>

<!-- Gráfico de barras para empleados -->
<canvas id="empleadosChart" width="300" height="100"></canvas>

<!-- Gráfico de barras para clientes -->
<canvas id="clientesChart" width="300" height="100"></canvas>

<!-- Gráfico de barras para reservaciones -->
<canvas id="reservacionesChart" width="300" height="100"></canvas>

<script>
    // Datos para los gráficos
    var usuariosData = <?php echo json_encode($currentUsuariosData); ?>;
    var empleadosData = <?php echo json_encode($currentEmpleadosData); ?>;
    var clientesData = <?php echo json_encode($currentClientesData); ?>;
    var reservacionesData = <?php echo json_encode($currentReservacionesData); ?>;

    // Función para crear el gráfico de barras
    function createChart(canvasId, chartLabel, chartData) {
        var ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(chartData),
                datasets: [{
                    label: chartLabel,
                    data: Object.values(chartData),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Crear gráficos
    createChart('usuariosChart', 'Usuarios', usuariosData);
    createChart('empleadosChart', 'Empleados', empleadosData);
    createChart('clientesChart', 'Clientes', clientesData);
    createChart('reservacionesChart', 'Reservaciones', reservacionesData);

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

<!-- ... Resto de tu código JavaScript y HTML ... -->

</body>
</html>

<?php
// CERRAR CONEXION
$conn->close();
?>
