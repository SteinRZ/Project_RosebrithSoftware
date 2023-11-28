<?php
session_start();
include 'db_config.php';

$usuario_encontrado = false; // Variable para controlar si se encontró al usuario

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["iniciar_sesion"])) {
    $correo = $_POST["email2"];
    $contrasena = $_POST["pswd2"];

    $sql = "SELECT * FROM usuario WHERE Correo = '$correo' AND Contraseña = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $_SESSION['id_usuario'] = $usuario['ID_Usuario'];
        $_SESSION['correo'] = $usuario['Correo'];
        $_SESSION['rol'] = $usuario['Rol'];

        $rol = $usuario['Rol'];

        switch ($rol) {
            case 'cliente':
                header("Location: client_page.php");
                break;
            case 'administrador':
                header("Location: contact_us.php");
                break;
            case 'empleado':
                header("Location: employee_page.php");
                break;
            default:
                header("Location: login.php");
                break;
        }
        $usuario_encontrado = true; // Indica que se encontró al usuario
        exit();
    }
}

// Verificar si no se encontró al usuario y mostrar el mensaje
if (!$usuario_encontrado && isset($_POST["iniciar_sesion"])) {
    echo "<script>alert('El usuario no existe, Asegurate de tener una cuenta registrada.');</script>";
}

// CERRAR CONEXION
$conn->close();
?>