<?php
        session_start();

        // CONFIGURACION DE LA BASE DE DATOS
        include("..\php\db_config.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recupera los datos del formulario para Empleado
            $id_empleado = $_POST['ID_Empleado'];
            $nombres = $_POST['Nombre'];
            $apellidos_paterno = $_POST['Apellido_Paterno'];
            $apellidos_materno = $_POST['Apellido_Materno'];
            $areas = $_POST['Area'];
            $telefonos = $_POST['Telefono'];
            $sueldos = $_POST['Sueldo'];

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
                    echo "Error al actualizar el empleado ID $id: " . $stmt->error;
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
        }
        ?>

        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Guardar Cambios Empleado</title>
        </head>
        <body>

        <!-- Botón de Regresar -->
        <a href="../html/admin_page.php">Regresar</a>

        </body>
        </html>