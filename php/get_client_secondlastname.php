<?php
include 'db_config.php'; // Archivo de configuración de la base de datos

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Obtener el ID del cliente desde la solicitud GET
    $id_cliente = $_GET['id'];

    // Realizar la consulta para obtener el apellido paterno del cliente según el ID
    $query = "SELECT Apellido_Materno FROM cliente WHERE ID_Cliente = $id_cliente";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $apellido_materno = $row['Apellido_Materno'];
        echo $apellido_materno; // Devolver el apellido paterno del cliente como respuesta
    } else {
        echo "Cliente no encontrado";
    }
} else {
    echo "Solicitud inválida";
}
?>