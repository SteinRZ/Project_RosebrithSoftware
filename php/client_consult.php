<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id_usuario'])) {
    // CONFIGURACION DE LA BASE DE DATOS
    include 'db_config.php';

    $id_usuario = mysqli_real_escape_string($conn, $_SESSION['id_usuario']);

    // Verificar si el usuario es un cliente
    $sql_cliente = "SELECT c.ID_Cliente, c.Telefono, 
                           c.Nombre AS NombreCliente,
                           c.Apellido_Paterno,
                           c.Apellido_Materno
                    FROM cliente c
                    INNER JOIN usuario u ON c.ID_Usuario = u.ID_Usuario
                    WHERE u.ID_Usuario = '$id_usuario'";

    $result_cliente = $conn->query($sql_cliente);

    if ($result_cliente->num_rows > 0) {
        $row_cliente = $result_cliente->fetch_assoc();
        // Aquí puedes utilizar los datos del cliente obtenidos
        $ID_Cliente = $row_cliente['ID_Cliente'];
        $nombre_cliente = $row_cliente['NombreCliente'];
        $apellido_paterno_cliente = $row_cliente['Apellido_Paterno'];
        $apellido_materno_cliente = $row_cliente['Apellido_Materno'];
        $telefono_cliente = $row_cliente['Telefono'];

        // Puedes utilizar estos datos para realizar otras operaciones o mostrarlos en tu aplicación
    } else {
        echo "No se encontró información del cliente.";
    }

    // CERRAR CONEXION
    $conn->close();
} else {
    echo "<script>alert('No se ha iniciado sesión, para realizar una reserva necesitas iniciar sesión.');
    window.location.href='../html/login.php';</script>";
}
?>
