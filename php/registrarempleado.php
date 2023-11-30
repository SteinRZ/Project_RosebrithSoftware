<?php
// CONFIGURACION DE LA BASE DE DATOS
ini_set('display_errors', 0);
include 'db_config.php';

// VERIFICAR ENVIO DEL FORMULARIO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DATOS DEL FORMULARIO
    $nombre = $_POST["name"];
    $apellidoPaterno = $_POST["apellidoP"];
    $apellidoMaterno = $_POST["apellidoM"];
    $correo = $_POST["email"];
    $telefono = $_POST["telefono"];
    $area = $_POST["area"];
    $sueldo = $_POST["sueldo"];
    $contrasena = $_POST["pswd"];

    // DECLARACION DE INSERCION EN LA TABLA "usuario"
    $sql_usuario = "INSERT INTO usuario (Nombre, Apellido_Paterno, Apellido_Materno, Correo, Contraseña, Rol) VALUES ('$nombre', '$apellidoPaterno', '$apellidoMaterno', '$correo','$contrasena', 'empleado')";

    // EJECUCION DE CONSULTA EN LA TABLA "usuario"
    if ($conn->query($sql_usuario) === TRUE) {
        // Obtener el ID de usuario recién insertado
        $idUsuario = $conn->insert_id;

        // DECLARACION DE INSERCION EN LA TABLA "empleado"
        $sql_cliente = "INSERT INTO empleado (ID_Usuario,area,Telefono,sueldo) VALUES ('$idUsuario','$area','$telefono', '$sueldo')";

        // EJECUCION DE CONSULTA EN LA TABLA "cliente"
        if ($conn->query($sql_cliente) === TRUE) {
            // echo "Usuario y Cliente registrados correctamente.";
        } else {
            // echo "Error al registrar cliente: " . $conn->error;
        }
    } else {
        // echo "Error al registrar usuario: " . $conn->error;
    }
}

// CERRAR CONEXION
$conn->close();
?>