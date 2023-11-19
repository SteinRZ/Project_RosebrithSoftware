<?php
// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

// VERIFICAR ENVIO DEL FORMULARIO DE INICIO DE SESION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["iniciar_sesion"])) {
    // DATOS DEL FORMULARIO DE INICIO DE SESION
    $correo = $_POST["email2"];
    $contrasena = $_POST["pswd2"];

    // VALIDAR USUARIO Y CONTRASEÑA Y OBTENER DATOS DEL USUARIO
    $sql = "SELECT * FROM usuario WHERE Correo = '$correo' AND Contraseña = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuario encontrado
        $usuario = $result->fetch_assoc();

        // Obtener el rol del usuario
        $rol = $usuario['Rol'];

        // Redirigir según el rol
        switch ($rol) {
            case 'cliente':
                header("Location: main.php");
                break;
            case 'administrador':
                header("Location: contact_us.php");
                break;
            case 'empleado':
                header("Location: services.php");
                break;
            // Agrega más casos según tus roles
            default:
                // Redirección predeterminada o mensaje de error
                header("Location: login.php");
                break;
        }
        exit();
    } else {
        // Usuario o contraseña incorrectos
        echo "<script>alert('Correo o contraseña incorrectos.');</script>";
    }
}

// CERRAR CONEXION
$conn->close();
?>