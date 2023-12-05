<?php
session_start();

// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['Usuario'];

    // Verificar si el ID es válido y no está vacío
    if (!empty($id) && is_numeric($id)) {
        // Eliminar las reservaciones asociadas al cliente
        $sql_delete_reservaciones = "DELETE FROM Reservacion WHERE ID_Cliente IN (SELECT ID_Cliente FROM Cliente WHERE ID_Usuario = $id)";

        if ($conn->query($sql_delete_reservaciones) === TRUE) {
            // Una vez eliminadas las reservaciones, procedemos a eliminar el cliente
            $sql_delete_cliente = "DELETE FROM Cliente WHERE ID_Usuario = $id";

            if ($conn->query($sql_delete_cliente) === TRUE) {
                // Finalmente, eliminamos el usuario
                $sql_delete_usuario = "DELETE FROM usuario WHERE ID_Usuario = $id";

                if ($conn->query($sql_delete_usuario) === TRUE) {
                    echo "<script>
                        alert('Usuario eliminado correctamente.');
                        window.location.href='../html/new_admin_page.php';
                      </script>";
                } else {
                    echo "<script>
                        alert('Error al eliminar el usuario.');
                        window.location.href='../html/new_admin_page.php';
                      </script>";
                }
            } else {
                echo "<script>
                    alert('Error al eliminar el cliente.');
                    window.location.href='../html/new_admin_page.php';
                  </script>";
            }
        } else {
            echo "<script>
                alert('Error al eliminar las reservaciones asociadas al cliente.');
                window.location.href='../html/new_admin_page.php';
              </script>";
        }
    } else {
        echo "<script>
            alert('ID de usuario no válido.');
            window.location.href='../html/new_admin_page.php';
          </script>";
    }
}
// CERRAR CONEXION
$conn->close();
?>