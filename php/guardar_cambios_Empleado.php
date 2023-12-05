<?php
    session_start();

    // CONFIGURACION DE LA BASE DE DATOS
    include 'db_config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_empleado'])) {
        // Recupera los datos del formulario para Empleado
        $id_empleado = $_POST['ID_Empleado'];
        $nombres = $_POST['Nombre'];
        $apellidos_paterno = $_POST['Apellido_Paterno'];
        $apellidos_materno = $_POST['Apellido_Materno'];
        $areas = $_POST['Area'];
        $telefonos = $_POST['Telefono'];
        $sueldos = $_POST['Sueldo'];
        $success = true;

        // Recorre los arreglos para actualizar cada registro
        for ($i = 0; $i < count($id_empleado); $i++) {
            $id = $id_empleado[$i];
            $nombre = $nombres[$i];
            $apellido_paterno = $apellidos_paterno[$i];
            $apellido_materno = $apellidos_materno[$i];
            $area = $areas[$i];
            $telefono = $telefonos[$i];
            $sueldo = $sueldos[$i];

            // Actualiza la tabla Empleado usando declaraciones preparadas
            $stmt = $conn->prepare("UPDATE Empleado 
                                SET Nombre=?, Apellido_Paterno=?, Apellido_Materno=?, 
                                    Area=?, Telefono=?, Sueldo=? 
                                WHERE ID_Empleado=?");
            $stmt->bind_param("ssssssi", $nombre, $apellido_paterno, $apellido_materno, $area, $telefono, $sueldo, $id);
            $stmt->execute();

            // Verifica si hubo un error
            if ($stmt->error) {
                // Puedes registrar el error en un archivo de registro o mostrar un mensaje en la página
                $success = false;
                echo "Error al actualizar el empleado ID $id: " . $stmt->error;
                // Detiene el bucle si hay un error
                break;
            }

            $stmt->close();
        }

        // Cierra la conexión después de terminar de ejecutar todas las consultas
        $conn->close();

        // Muestra la alerta si la modificación se realizó con éxito
        if ($success) {
            echo "<script>
                    alert('Se ha modificado el empleado con éxito.');
                    window.location.href='../php/admin_table_employee.php';
                  </script>";
            exit; // Asegura que el script se detenga después de la redirección
        }
    }
?>