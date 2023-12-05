<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Usuario'])) {
    $id = $_POST['Usuario'];

    // Verificar si el ID es válido y no está vacío
    if (!empty($id) && is_numeric($id)) {
        // Verificar el rol del usuario antes de eliminarlo
        $sql_select_rol = "SELECT Rol FROM usuario WHERE ID_Usuario = $id";
        $result_rol = $conn->query($sql_select_rol);

        if ($result_rol) {
            $row = $result_rol->fetch_assoc();
            $rol = $row['Rol'];

            // Verificar el rol para eliminar adecuadamente
            if ($rol === "empleado") {
                // Eliminar las reservaciones asociadas al empleado
                $sql_delete_reservaciones = "DELETE FROM Reservacion WHERE ID_Cliente IN (SELECT ID_Cliente FROM Cliente WHERE ID_Usuario = $id)";

                if ($conn->query($sql_delete_reservaciones) === TRUE) {
                    // Una vez eliminadas las reservaciones, procedemos a eliminar el empleado
                    $sql_delete_empleado = "DELETE FROM empleado WHERE ID_Usuario = $id";

                    if ($conn->query($sql_delete_empleado) === TRUE) {
                        // Finalmente, eliminamos el usuario
                        $sql_delete_usuario = "DELETE FROM usuario WHERE ID_Usuario = $id";

                        if ($conn->query($sql_delete_usuario) === TRUE) {
                            echo "<script>
                                alert('Empleado eliminado correctamente.');
                                window.location.href='../html/admin_page.php';
                            </script>";
                        } else {
                            echo "<script>
                                alert('Error al eliminar el empleado.');
                                window.location.href='../html/admin_page.php';
                            </script>";
                        }
                    } else {
                        echo "<script>
                            alert('Error al eliminar el empleado.');
                            window.location.href='../html/admin_page.php';
                        </script>";
                    }
                } else {
                    // Alerta si no se pueden eliminar las reservaciones asociadas al empleado
                    echo "<script>
                        alert('No se pudo eliminar el empleado debido a reservaciones asociadas.');
                        window.location.href='../html/admin_page.php';
                    </script>";
                }
            } else {
                // Eliminar las reservaciones asociadas al cliente
                $sql_delete_reservaciones_cliente = "DELETE FROM Reservacion WHERE ID_Cliente IN (SELECT ID_Cliente FROM Cliente WHERE ID_Usuario = $id)";

                if ($conn->query($sql_delete_reservaciones_cliente) === TRUE) {
                    // Una vez eliminadas las reservaciones, procedemos a eliminar el cliente
                    $sql_delete_cliente = "DELETE FROM Cliente WHERE ID_Usuario = $id";

                    if ($conn->query($sql_delete_cliente) === TRUE) {
                        // Finalmente, eliminamos el usuario (cliente)
                        $sql_delete_usuario = "DELETE FROM usuario WHERE ID_Usuario = $id";

                        if ($conn->query($sql_delete_usuario) === TRUE) {
                            echo "<script>
                                alert('Cliente eliminado correctamente.');
                                window.location.href='../html/admin_page.php';
                            </script>";
                        } else {
                            echo "<script>
                                alert('Error al eliminar el cliente.');
                                window.location.href='../html/admin_page.php';
                            </script>";
                        }
                    } else {
                        echo "<script>
                            alert('Error al eliminar el cliente.');
                            window.location.href='../html/admin_page.php';
                        </script>";
                    }
                } else {
                    // Alerta si no se pueden eliminar las reservaciones asociadas al cliente
                    echo "<script>
                        alert('No se pudo eliminar el cliente debido a reservaciones asociadas.');
                        window.location.href='../html/admin_page.php';
                    </script>";
                }
            }
        } else {
            // Manejar error al obtener el rol del usuario
            echo "<script>
                alert('Error al obtener el rol del usuario.');
                window.location.href='../html/admin_page.php';
            </script>";
        }
    } else {
        // Alerta si el ID de usuario no es válido
        echo "<script>
            alert('ID de usuario no válido.');
            window.location.href='../html/admin_page.php';
        </script>";
    }
}

// CERRAR CONEXION
$conn->close();
?>