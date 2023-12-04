<?php
// Archivo registrar_empleado.php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario para Empleado
    $nombre = $_POST['name'];
    $apellidoPaterno = $_POST['apellidoP'];
    $apellidoMaterno = $_POST['apellidoM'];
    $correo = $_POST['email'];
    $telefono = $_POST['telefono'];
    $area = $_POST['area'];
    $sueldo = $_POST['sueldo'];
    $contrasena = $_POST['pswd'];

    // Obtiene la fecha actual
    $fechaCreacion = date("Y-m-d");

    // Inserta un nuevo registro en la tabla Usuario
    $sqlInsertUsuario = "INSERT INTO usuario (Correo, Contraseña, Rol, Fecha_Creacion)
                         VALUES ('$correo', '$contrasena', 'empleado', '$fechaCreacion')";

    if ($conn->query($sqlInsertUsuario)) {
        // Obtiene el ID del usuario recién insertado
        $idUsuario = $conn->insert_id;

        // Inserta un nuevo registro en la tabla Empleado asociado al usuario
        $sqlInsertEmpleado = "INSERT INTO empleado (ID_Usuario, Nombre, Apellido_Paterno, Apellido_Materno, Area, Telefono, Sueldo, Fecha_Creacion)
                              VALUES ('$idUsuario', '$nombre', '$apellidoPaterno', '$apellidoMaterno', '$area', '$telefono', '$sueldo', '$fechaCreacion')";

        if ($conn->query($sqlInsertEmpleado) === TRUE) {
            echo "<script>
                
                window.location.href='../html/admin_page.php'; // Cambia esto a la página que desees
            </script>";
        } else {
            echo "Error al registrar el empleado: " . $conn->error;
        }
    } else {
        echo "Error al registrar el usuario del empleado: " . $conn->error; // Error mostrado
    }

    // Cierra la conexión
    $conn->close();
}

?>