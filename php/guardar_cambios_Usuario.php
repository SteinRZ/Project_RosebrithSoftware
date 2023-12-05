<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_usuario'])) {
    // Recupera los datos del formulario para Usuario
    $Id_usuario = $_POST['ID_Usuario'];
    $Correos = $_POST['Correo'];
    $Contraseñas = $_POST['Contraseña'];
    $Roles = $_POST['Rol'];

    // Recorre los arreglos para actualizar cada registro
    for ($i = 0; $i < count($Id_usuario); $i++) {
        $id = $Id_usuario[$i];
        $correo = $Correos[$i];
        $contraseña = $Contraseñas[$i];
        $rol = $Roles[$i];

        // Actualiza la tabla Usuario usando declaraciones preparadas
        $stmt = $conn->prepare("UPDATE usuario SET Correo=?, Contraseña=?, Rol=? WHERE ID_Usuario=?");
        $stmt->bind_param("sssi", $correo, $contraseña, $rol, $id);
        $stmt->execute();

        // Verifica si hubo un error
        if ($stmt->error) {
            // Puedes registrar el error en un archivo de registro o mostrar un mensaje en la página
            echo "Error al actualizar el usuario ID $id: " . $stmt->error;
            // Detiene el bucle si hay un error
            break;
        }

        $stmt->close();
    }

    // Cierra la conexión después de terminar de ejecutar todas las consultas
    $conn->close();

    // Redirecciona después de actualizar todos los registros
    echo "<script>
                alert('Cambios realizados con éxito.');
                window.location.href='../html/new_admin_page.php';
              </script>";
    exit; // Asegura que el script se detenga después de la redirección
}
?>