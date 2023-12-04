<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// CONFIGURACION DE LA BASE DE DATOS
include ("..\php\db_config.php");


// CONSULTA DE USUARIOS
$sql_usuario = "SELECT * FROM usuario";
$result_usuario = $conn->query($sql_usuario);

// CONSULTA DE EMPLEADOS
$sql_empleado = "SELECT * FROM Empleado";
$result_empleado = $conn->query($sql_empleado);

// CONSULTA DE CLIENTES
$sql_cliente = "SELECT * FROM Cliente";
$result_cliente = $conn->query($sql_cliente);

// CONSULTA DE RESERVACIONES
$sql_reservacion = "SELECT * FROM Reservacion";
$result_reservacion = $conn->query($sql_reservacion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosebrith | Mostrar Tablas</title>
    <link rel="icon" href="../image/main_icon.png">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/style_reserve.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap">

    <link rel="icon" href="../image/main_icon.png">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/style_reserve.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap">

    <!-- Incluye jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Incluye DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">

<!-- Incluye DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <!-- Agregamos la biblioteca de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* Tus estilos CSS aquí */
    </style>
    <style>
    /* Agrega estilos de centrado para las tablas */
    .table-container {
        margin: 0 auto;
        width: 80%; /* Puedes ajustar el ancho según tus necesidades */
        text-align: center;
    }

    /* Estilos para el botón de eliminar y guardar */
    button[type="submit"] {
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 4px;
        color: #fff; /* Cambia el color del texto a blanco */
        opacity: 1;
    }

    button[type="submit"][formaction="../php/eliminar_registro.php"] {
        background-color: #ff3333; /* Cambia el color a rojo para el botón de eliminar */
    }

    button[type="submit"]:hover {
        opacity: 0.8; /* Reduce ligeramente la opacidad al pasar el ratón */
    }

    .guardar-button:hover {
        cursor: pointer; /* Cambia la forma del cursor al pasar sobre el botón de guardar */
    }

    /* Agrega estilos para el formulario de registro */
    .formulario-container {
        width: 50%;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #f8f8f8;
    }

    .formulario-container h2 {
        text-align: center;
        color: #333;
    }

    .formulario-container form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .formulario-container label {
        margin-top: 10px;
        font-weight: bold;
        color: #555;
    }

    .formulario-container input {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 15px;
        box-sizing: border-box;
    }

    .formulario-container button {
        padding: 10px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .formulario-container button:hover {
        background-color: #45a049;
    }

/* Estilo para ajustar el tamaño de las celdas en la tabla de Reservaciones */
#tablaReservaciones td, #tablaReservaciones th {
    padding: 5px;            /* Ajusta el relleno de las celdas */
}

#tablaReservaciones td:nth-child(1), #tablaReservaciones th:nth-child(1) {
    max-width: 60px;         /* Ajusta el ancho máximo para la primera columna */
    font-size: 12px;         /* Ajusta el tamaño de la fuente si es necesario */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}




    
</style>




</head>
<body>

<!--------------------NAVBAR--------------------->
<header class="navbar">
        <div class="navbar__icon">
            <a href="main.php"><img src="../image/main_icon.png" alt="Rosebrith" title="Inicio"></a>
        </div>
        <nav>
           <ul class="nav__links">
                
           </ul>            
        </nav>
        <a class="navbar__button" href="../php/logout.php"><button>Cerrar sesión</button></a>  
        <?php include '..\php\change_button.php';?>
    </header>

    <div class="table-container">
    <h2>Tabla Usuarios</h2>
    <form action='../php/guardar_cambios_Usuario.php' method='post'>
        <table id="tablaUsuarios" class="display" border="1">
            <thead>
                <tr>
                    <th>ID_Usuario</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Fecha Creación</th>
                    <th>Acciones</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result_usuario->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='hidden' name='ID_Usuario[]' value='" . $row['ID_Usuario'] . "'>" . $row['ID_Usuario'] . "</td>";
                    echo "<td><input type='text' name='Correo[]' value='" . htmlspecialchars($row['Correo'] ?? '') . "'></td>";
                    // Mostrar la contraseña como texto claro
                    echo "<td><input type='text' name='Contraseña[]' value='" . htmlspecialchars($row['Contraseña'] ?? '') . "'></td>";
                    echo "<td><input type='text' name='Rol[]' value='" . htmlspecialchars($row['Rol'] ?? '') . "'></td>";
                    
                    // Campo Fecha_Creacion (no editable)
                    echo "<td><input type='text' name='Fecha_Creacion[]' value='" . $row['Fecha_Creacion'] . "' readonly></td>";

                    // Botón Guardar
                    echo "<td><input type='submit' class='guardar-button' value='Guardar'></td>";
                    // Botón Eliminar
                    echo "<td><button type='submit' formaction='../php/eliminar_registro.php' name='ID' value='" . $row['ID_Usuario'] . "'>Eliminar</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </form>
</div>







<!-- Mostrar tabla Empleado -->
<div class="table-container">
    <br>
    <h2>Tabla de Empleados</h2>
    <form action='../php/guardar_cambios_Empleado.php' method='post'>
        <table id="tablaEmpleados" class="display" border="1">
            <thead>
                <tr>
                    <th>ID_Empleado</th>
                    <th>ID_Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Area</th>
                    <th>Telefono</th>
                    <th>Sueldo</th>
                    <th>Fecha Creación</th>
                    <th>Acciones</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result_empleado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='hidden' name='ID_Empleado[]' value='" . $row['ID_Empleado'] . "'>" . $row['ID_Empleado'] . "</td>";
                    echo "<td><span>" . $row['ID_Usuario'] . "</span></td>";
                    echo "<td><input type='text' name='Nombre[]' value='" . htmlspecialchars($row['Nombre'] ?? '') . "'></td>";
                    echo "<td><input type='text' name='Apellido_Paterno[]' value='" . htmlspecialchars($row['Apellido_Paterno'] ?? '') . "'></td>";
                    echo "<td><input type='text' name='Apellido_Materno[]' value='" . htmlspecialchars($row['Apellido_Materno'] ?? '') . "'></td>";
                    echo "<td><input type='text' name='Area[]' value='" . $row['Area'] . "'></td>";
                    echo "<td><input type='text' name='Telefono[]' value='" . $row['Telefono'] . "'></td>";
                    echo "<td><input type='text' name='Sueldo[]' value='" . $row['Sueldo'] . "'></td>";
                    // Campo Fecha_Creacion (no editable)
                    echo "<td><input type='text' name='Fecha_Creacion[]' value='" . $row['Fecha_Creacion'] . "' readonly></td>";
                    // Botón Guardar
                    echo "<td><input type='submit' class='guardar-button' value='Guardar'></td>";
                    // Botón Eliminar
                    echo "<td><button type='submit' formaction='../php/eliminar_registro.php' name='ID' value='" . $row['ID_Empleado'] . "'>Eliminar</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </form>
</div>








<!-- Mostrar tabla Cliente -->
<div class="table-container">
    <br>
    <h2>Tabla de Clientes</h2>
    <form action='../php/guardar_cambios_Cliente.php' method='post'>
        <table id="tablaClientes" class="display" border="1">
            <thead>
                <tr>
                    <th>ID_Cliente</th>
                    <th>ID_Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Telefono</th>
                    <th>Fecha Creación</th>
                    <th>Acciones</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result_cliente->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='hidden' name='ID_Cliente[]' value='" . $row['ID_Cliente'] . "'>" . $row['ID_Cliente'] . "</td>";
                    echo "<td><span>" . $row['ID_Usuario'] . "</span></td>";
                    echo "<td><input type='text' name='Nombre[]' value='" . $row['Nombre'] . "'></td>";
                    echo "<td><input type='text' name='Apellido_Paterno[]' value='" . $row['Apellido_Paterno'] . "'></td>";
                    echo "<td><input type='text' name='Apellido_Materno[]' value='" . $row['Apellido_Materno'] . "'></td>";
                    echo "<td><input type='text' name='Telefono[]' value='" . $row['Telefono'] . "'></td>";
                    echo "<td>" . $row['Fecha_Creacion'] . "</td>";
                    // Botón Guardar
                    echo "<td><input type='submit' class='guardar-button' value='Guardar'></td>";
                    // Botón Eliminar
                    echo "<td><button type='submit' formaction='../php/eliminar_registro.php' name='ID' value='" . $row['ID_Cliente'] . "'>Eliminar</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </form>
</div>






<!-- Mostrar tabla Reservacion -->
<div class="table-container">
    <br>
    <h2>Tabla de Reservaciones</h2>
    <form action='../php/guardar_cambios_Reservacion.php' method='post'>
        <table id="tablaReservaciones" class="display" border="1">
            <thead>
                <tr>
                    <th>ID_Reservacion</th>
                    <th>ID_Cliente</th>
                    <th>Fecha_Reserva</th>
                    <th>Tipo_Reserva</th>
                    <th>Anticipo</th>
                    <th>Hora_Inicio</th>
                    <th>Hora_Finalizado</th>
                    <th>Duracion</th>
                    <th>Total</th>
                    <th>Comentario</th>
                    <th>Fecha_Creacion</th>
                    <th>Acciones</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result_reservacion->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='hidden' name='ID_Reservacion[]' value='" . $row['ID_Reservacion'] . "'>" . $row['ID_Reservacion'] . "</td>";
                    echo "<td><span>" . $row['ID_Cliente'] . "</span></td>";
                    echo "<td><input type='text' name='Fecha_Reserva[]' value='" . $row['Fecha_Reserva'] . "'></td>";
                    echo "<td><input type='text' name='Tipo_Reserva[]' value='" . $row['Tipo_Reserva'] . "'></td>";
                    echo "<td><input type='text' name='Anticipo[]' value='" . $row['Anticipo'] . "'></td>";
                    echo "<td><input type='text' name='Hora_Inicio[]' value='" . $row['Hora_Inicio'] . "'></td>";
                    echo "<td><input type='text' name='Hora_Finalizado[]' value='" . $row['Hora_Finalizado'] . "'></td>";
                    echo "<td><input type='text' name='Duracion[]' value='" . $row['Duracion'] . "'></td>";
                    echo "<td><input type='text' name='Total[]' value='" . $row['Total'] . "'></td>";
                    echo "<td><input type='text' name='Comentario[]' value='" . $row['Comentario'] . "'></td>";
                    echo "<td><span>" . $row['Fecha_Creacion'] . "</span></td>";
                    // Botón Guardar
                    echo "<td><input type='submit' class='guardar-button' value='Guardar'></td>";
                    // Botón Eliminar
                    echo "<td><button type='submit' formaction='../php/eliminar_registro.php' name='ID' value='" . $row['ID_Reservacion'] . "'>Eliminar</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </form>
</div>





<!-- Agrega este formulario donde desees en tu página -->
<div class="formulario-container">
    <h2>Registrar Empleado</h2>
    <form name="registrarempleado" method="post" action="../php/registrar_empleado.php">
        <input type="name" name="name" placeholder="Nombre" required="">

        <input type="lname" name="apellidoP" placeholder="Apellido Paterno" required="">

        <input type="lname" name="apellidoM" placeholder="Apellido Materno" required="">

        <input type="email" name="email" placeholder="Correo" required="">

        <input type="tel" name="telefono" placeholder="Telefono" required="" pattern="[0-9]{10}">

        <select id="area" name="area" placeholder="Area"  required>
        <option value="Alberca">Alberca</option>
        <option value="Salón">Salón</option>
        </select>

        <input type="float" id="sueldo" placeholder="Sueldo" name="sueldo" required>

        <input type="password" name="pswd" placeholder="Contraseña" required="">

    
        <button type="submit">Registrar</button>
    </form>
</div>
<!-- Gráfico de barras agrupadas para Usuarios, Empleados, Clientes y Reservaciones -->
<canvas id="groupedChart" width="300" height="100"></canvas>

<script>
    // Datos para los gráficos
    var usuariosData = <?php echo $result_usuario->num_rows; ?>;
    var empleadosData = <?php echo $result_empleado->num_rows; ?>;
    var clientesData = <?php echo $result_cliente->num_rows; ?>;
    var reservacionesData = <?php echo $result_reservacion->num_rows; ?>;

    // Función para crear gráfico de barras agrupadas
    function createGroupedChart() {
        var ctx = document.getElementById('groupedChart').getContext('2d');
        var groupedChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Usuarios', 'Empleados', 'Clientes', 'Reservaciones'],
                datasets: [
                    {
                        label: 'Cantidad',
                        data: [usuariosData, empleadosData, clientesData, reservacionesData],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Crear gráfico de barras agrupadas
    createGroupedChart();


    
    
    $(document).ready(function () {
    $('#tablaUsuarios, #tablaEmpleados, #tablaClientes, #tablaReservaciones').DataTable({
        "search": {
            "smart": false,
            "caseInsensitive": true
        },
        "searching": true
    });
});





</script>

</body>
</html>

<?php
// CERRAR CONEXION
$conn->close();
?>