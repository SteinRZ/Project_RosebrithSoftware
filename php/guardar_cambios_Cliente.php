<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include("..\php\db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario para Cliente
    $id_cliente = $_POST['ID_Cliente'];
    $nombres = $_POST['Nombre'];
    $apellidos_paterno = $_POST['Apellido_Paterno'];
    $apellidos_materno = $_POST['Apellido_Materno'];
    $telefonos = $_POST['Telefono'];

    // Verifica si $id_cliente es un array antes de intentar contar sus elementos
    if (is_array($id_cliente)) {
        // Recorre los arreglos para actualizar cada registro
        for ($i = 0; $i < count($id_cliente); $i++) {
            $id = $id_cliente[$i];
            $nombre = $nombres[$i];
            $apellido_paterno = $apellidos_paterno[$i];
            $apellido_materno = $apellidos_materno[$i];
            $telefono = $telefonos[$i];

            // Actualiza la tabla Cliente usando declaraciones preparadas
            $stmt = $conn->prepare("UPDATE Cliente 
                                   SET Nombre=?, Apellido_Paterno=?, Apellido_Materno=?, Telefono=? 
                                   WHERE ID_Cliente=?");
            $stmt->bind_param("ssssi", $nombre, $apellido_paterno, $apellido_materno, $telefono, $id);
            $stmt->execute();

            // Verifica si hubo un error
            if ($stmt->error) {
                // Puedes registrar el error en un archivo de registro o mostrar un mensaje en la página
                echo "Error al actualizar el cliente ID $id: " . $stmt->error;
                // Detiene el bucle si hay un error
                break;
            }

            $stmt->close();
        }

        // Cierra la conexión después de terminar de ejecutar todas las consultas
        $conn->close();

        // Redirecciona después de actualizar todos los registros
        header("Location: ../html/admin_page.php");
        exit; // Asegura que el script se detenga después de la redirección
    } else {
        echo "<script>
            alert('Error: El ID del cliente no es un array válido.');
            window.location.href='../html/admin_page.php';
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar Cambios Cliente</title>
</head>
<body>

<!-- Botón de Regresar -->
<a href="../html/admin_page.php">Regresar</a>

</body>
</html>
