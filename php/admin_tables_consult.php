<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// CONFIGURACION DE LA BASE DE DATOS
include ("../php/db_config.php");


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