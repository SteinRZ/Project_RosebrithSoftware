<?php
// Archivo insertar_cliente.php
include 'db_config.php';

// Obtiene los datos del formulario
$nombre = $_POST['name'];
$apellidoPaterno = $_POST['apellidoP'];
$apellidoMaterno = $_POST['apellidoM'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$contrasena = $_POST['pswd'];

// Inserta el nuevo usuario en la tabla "usuario"
$sqlUsuario = "INSERT INTO usuario (Correo, Contraseña, Rol, Fecha_Creacion)
              VALUES ('$email', '$contrasena', 'cliente', NOW())";

if ($conn->query($sqlUsuario) === TRUE) {
    // Obtén el ID del usuario insertado
    $idUsuarioInsertado = $conn->insert_id;

    // Inserta el nuevo cliente en la tabla "cliente"
    $sqlCliente = "INSERT INTO cliente (ID_Usuario, Nombre, Apellido_Paterno, Apellido_Materno, Telefono, Fecha_Creacion)
                  VALUES ('$idUsuarioInsertado', '$nombre', '$apellidoPaterno', '$apellidoMaterno', '$telefono', NOW())";

    if ($conn->query($sqlCliente) === TRUE) {
        echo "<script>
        alert('Cliente registrado exitosamente.');
        window.location.href='../html/login.php';
        </script>";
    } else {
        echo "Error al registrar el cliente: " . $conn->error;
    }
} else {
    echo "Error al registrar el usuario: " . $conn->error;
}

// Cierra la conexión
$conn->close();
?>