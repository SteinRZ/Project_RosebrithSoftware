<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include ("..\php\db_config.php");




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
                <li><a href="services.php">Servicios</a></li>
                <li><a href="contact_us.php">Contactanos</a></li>
           </ul>            
        </nav>
        <a class="navbar__button" href="login.php"><button>Iniciar sesion</button></a>
    </header>

<!-- Mostrar tabla Empleado -->
<div class="table-container">
<h2>Tabla Empleado</h2>
<table border="1">
    <tr>
        <th>ID_Empleado</th>
        <th>ID_Usuario</th>
        <th>Area</th>
        <th>Telefono</th>
        <th>Sueldo</th>
        <!-- Agrega más columnas según la estructura de tu tabla Empleado -->
        <th>Acciones</th>
        <th>Eliminar</th>
    </tr>
    <?php
    while ($row = $result_empleado->fetch_assoc()) {
        echo "<tr>";
        echo "<form action='../php/guardar_cambios_Empleado.php' method='post'>";
        echo "<td>" . $row['ID_Empleado'] . "</td>";
        echo "<td><input type='hidden' name='ID_Empleado' value='" . $row['ID_Empleado'] . "'>" . $row['ID_Usuario'] . "</td>";
        echo "<td><input type='text' name='Area' value='" . $row['Area'] . "'></td>";
        echo "<td><input type='text' name='Telefono' value='" . $row['Telefono'] . "'></td>";
        echo "<td><input type='text' name='Sueldo' value='" . $row['Sueldo'] . "'></td>";
        // Botón Guardar
        echo "<td><input type='submit' class='guardar-button' value='Guardar'></td>";
        // Botón Eliminar
        echo "<td><button type='submit' formaction='../php/eliminar_registro.php' name='ID' value='" . $row['ID_Empleado'] . "'>Eliminar</button></td>";
        echo "</form>";
        echo "</tr>";
        
    }
    ?>
</table>
</div>



<!-- Mostrar tabla Cliente -->
<div class="table-container">
<h2>Tabla Cliente</h2>
<table border="1">
    <tr>
        <th>ID_Cliente</th>
        <th>ID_Usuario</th>
        <th>Telefono</th>
        <th>Deuda</th>
        <!-- Agrega más columnas según la estructura de tu tabla Cliente -->
        <th>Acciones</th>
        <th>Eliminar</th>
    </tr>
    <?php
    while ($row = $result_cliente->fetch_assoc()) {
        echo "<tr>";
        echo "<form action='../php/guardar_cambios_Cliente.php' method='post'>";
        echo "<td>" . $row['ID_Cliente'] . "</td>";
        echo "<td><input type='hidden' name='ID_Cliente' value='" . $row['ID_Cliente'] . "'>" . $row['ID_Usuario'] . "</td>";
        echo "<td><input type='text' name='Telefono' value='" . $row['Telefono'] . "'></td>";
        echo "<td><input type='text' name='Deuda' value='" . $row['Deuda'] . "'></td>";
        // Botón Guardar
        echo "<td><input type='submit' class='guardar-button' value='Guardar'></td>";
        // Botón Eliminar
        echo "<td><button type='submit' formaction='../php/eliminar_registro.php' name='ID' value='" . $row['ID_Cliente'] . "'>Eliminar</button></td>";
        echo "</form>";
        echo "</tr>";
        
    }
    ?>
</table>
</div>


<!-- Mostrar tabla Reservacion -->
<div class="table-container">
<h2>Tabla Reservacion</h2>
<table border="1">
    <tr>
        <th>ID_Reservacion</th>
        <th>ID_Cliente</th>
        <th>Fecha_Reserva</th>
        <th>Tipo_Reserva</th>
        <th>Anticipo</th>
        <th>Comentario</th>
        <!-- Agrega más columnas según la estructura de tu tabla Reservacion -->
        <th>Acciones</th>
        <th>Eliminar</th>
    </tr>
    <?php
    while ($row = $result_reservacion->fetch_assoc()) {
        echo "<tr>";
        echo "<form action='../php/guardar_cambios_Reservacion.php' method='post'>";
        echo "<td>" . $row['ID_Reservacion'] . "</td>";
        echo "<td><input type='hidden' name='ID_Reservacion' value='" . $row['ID_Reservacion'] . "'>" . $row['ID_Cliente'] . "</td>";
        echo "<td><input type='text' name='Fecha_Reserva' value='" . $row['Fecha_Reserva'] . "'></td>";
        echo "<td><input type='text' name='Tipo_Reserva' value='" . $row['Tipo_Reserva'] . "'></td>";
        echo "<td><input type='text' name='Anticipo' value='" . $row['Anticipo'] . "'></td>";
        echo "<td><input type='text' name='Comentario' value='" . $row['Comentario'] . "'></td>";
        // Botón Guardar
        echo "<td><input type='submit' class='guardar-button' value='Guardar'></td>";
        // Botón Eliminar
        echo "<td><button type='submit' formaction='../php/eliminar_registro.php' name='ID' value='" . $row['ID_Reservacion'] . "'>Eliminar</button></td>";
        echo "</form>";
        echo "</tr>";
        
    }
    ?>
</table>
</div>

<!-- Agrega este formulario donde desees en tu página -->
<div class="formulario-container">
    <h2>Registrar Empleado</h2>
    <form action="../php/registrar_empleado.php" method="post">
        <label for="id_usuario">ID Usuario:</label>
        <input type="text" id="id_usuario" name="id_usuario" required>

        <label for="area">Área:</label>
        <input type="text" id="area" name="area" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>

        <label for="sueldo">Sueldo:</label>
        <input type="text" id="sueldo" name="sueldo" required>

        <button type="submit">Registrar</button>
    </form>
</div>




</body>
</html>

<?php
// CERRAR CONEXION
$conn->close();
?>