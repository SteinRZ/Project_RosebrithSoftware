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

// Inserta el nuevo cliente en la tabla "usuario"
$sql = "INSERT INTO usuario (Correo, Contraseña, Rol)
        VALUES ('$email', '$contrasena', 'cliente')";

if ($conn->query($sql) === TRUE) {
    // Obtén el ID del usuario insertado
    $idUsuarioInsertado = $conn->insert_id;

    // Ahora, inserta el nuevo cliente en la tabla "cliente" usando el ID del usuario
    $sqlCliente = "INSERT INTO cliente (ID_Usuario, Nombre, Apellido_Paterno, Apellido_Materno, Telefono)
        VALUES ('$idUsuarioInsertado', '$nombre', '$apellidoPaterno', '$apellidoMaterno','$telefono' )";

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