<?php
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "rosebrith";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
    // echo "<script>console.log('Conexión exitosa a la base de datos.');</script>";
}
else{
    // echo "Conexión exitosa a la base de datos.";
}
?>