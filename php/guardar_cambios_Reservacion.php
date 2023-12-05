<?php
    session_start();

    // CONFIGURACION DE LA BASE DE DATOS
    include 'db_config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_reservacion'])) {
        // Recupera los datos del formulario para Reservacion
        $id_reservacion = $_POST['ID_Reservacion'];
        $fechas_reserva = $_POST['Fecha_Reserva'];
        $tipos_reserva = $_POST['Tipo_Reserva'];
        $anticipos = $_POST['Anticipo'];
        $horas_inicio = $_POST['Hora_Inicio'];
        $horas_finalizado = $_POST['Hora_Finalizado'];
        $duracion = $_POST['Duracion'];
        $totales = $_POST['Total'];
        $comentarios = $_POST['Comentario'];

        // Verifica si $id_reservacion es un array antes de intentar contar sus elementos
        if (is_array($id_reservacion)) {
            // Recorre los arreglos para actualizar cada registro
            for ($i = 0; $i < count($id_reservacion); $i++) {
                $id = $id_reservacion[$i];
                $fecha_reserva = $fechas_reserva[$i];
                $tipo_reserva = $tipos_reserva[$i];
                $anticipo = $anticipos[$i];
                $hora_inicio = $horas_inicio[$i];
                $hora_finalizado = $horas_finalizado[$i];
                $duracion_reserva = $duracion[$i];
                $total = $totales[$i];
                $comentario = $comentarios[$i];

                // Actualiza la tabla Reservacion usando declaraciones preparadas
                $stmt = $conn->prepare("UPDATE Reservacion 
                                    SET Fecha_Reserva=?, Tipo_Reserva=?, Anticipo=?, 
                                        Hora_Inicio=?, Hora_Finalizado=?, Duracion=?, 
                                        Total=?, Comentario=? 
                                    WHERE ID_Reservacion=?");
                $stmt->bind_param("ssssssdsi", $fecha_reserva, $tipo_reserva, $anticipo, 
                                $hora_inicio, $hora_finalizado, $duracion_reserva, 
                                $total, $comentario, $id);
                $stmt->execute();

                // Verifica si hubo un error
                if ($stmt->error) {
                    // Puedes registrar el error en un archivo de registro o mostrar un mensaje en la página
                    echo "Error al actualizar la reservación ID $id: " . $stmt->error;
                    // Detiene el bucle si hay un error
                    break;
                }

                $stmt->close();
            }

            // Cierra la conexión después de terminar de ejecutar todas las consultas
            $conn->close();

            // Redirecciona después de actualizar todos los registros
            echo "<script>
                alert('Se ha modificado la reservacion con éxito.');
                window.location.href='../php/admin_table_reservation.php';
                </script>";
            exit; // Asegura que el script se detenga después de la redirección
        } else {
            echo "<script>
                alert('Error: El ID de la reservación no es un array válido.');
                window.location.href='../php/admin_table_reservation.php';
                </script>";
        }
    }
?>