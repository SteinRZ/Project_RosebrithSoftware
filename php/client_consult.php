<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['id_usuario'])) {
    // CONFIGURACION DE LA BASE DE DATOS
    include 'db_config.php';

    $id_usuario = mysqli_real_escape_string($conn, $_SESSION['id_usuario']);

    // Verificar si el usuario es un empleado o un cliente
    $sql_usuario = "SELECT ID_Usuario, Rol FROM usuario WHERE ID_Usuario = '$id_usuario'";
    $result_usuario = $conn->query($sql_usuario);

    if ($result_usuario->num_rows > 0) {
        $row_usuario = $result_usuario->fetch_assoc();
        $rol_usuario = $row_usuario['Rol'];

        if ($rol_usuario === "cliente") {
            // Obtener la información del cliente
            $sql_cliente = "SELECT c.ID_Cliente, c.Telefono, c.Deuda,
                                    u.Nombre AS NombreCliente,
                                    u.Apellido_Paterno,
                                    u.Apellido_Materno
                            FROM cliente c
                            INNER JOIN usuario u ON c.ID_Usuario = u.ID_Usuario
                            WHERE c.ID_Usuario = '$id_usuario'";

            $result_cliente = $conn->query($sql_cliente);

            if ($result_cliente->num_rows > 0) {
                $row_cliente = $result_cliente->fetch_assoc();
                // Aquí puedes utilizar los datos del cliente obtenidos
                $ID_Cliente = $row_cliente['ID_Cliente'];
                $nombre_cliente = $row_cliente['NombreCliente'];
                $apellido_paterno_cliente = $row_cliente['Apellido_Paterno'];
                $apellido_materno_cliente = $row_cliente['Apellido_Materno'];
                $telefono_cliente = $row_cliente['Telefono'];
                $deuda_cliente = $row_cliente['Deuda'];

                // Puedes utilizar estos datos para realizar otras operaciones o mostrarlos en tu aplicación
            } else {
                echo "No se encontró información del cliente.";
            }
        } else {
            echo "El usuario no tiene el rol de cliente.";
        }
    } else {
        echo "No se encontró el usuario.";
    }

    // CERRAR CONEXION
    $conn->close();
} else {
    echo "<script>alert('No se ha iniciado sesión, para realizar una reserva necesitas iniciar sesión.');
    window.location.href='../html/login.php';</script>";
}
?>
