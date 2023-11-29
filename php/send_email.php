<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['field__name'];
    $email = $_POST['field__email'];
    $phone = $_POST['field__phone'];
    $subject = $_POST['field__affair'];
    $message = $_POST['field__message'];

    // Correo de destino (correo de la empresa)
    $to = "rosebrith@hotmail.com"; // Correo de la empresa

    // Configuración para enviar correo utilizando la dirección de correo de la persona que llena el formulario
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=utf-8',
        'From: ' . $email, // El correo de la persona que envía el formulario será el remitente
        'Reply-To: ' . $email, // La persona que envía el mensaje será el destinatario para respuestas
        'X-Mailer: PHP/' . phpversion()
    ];

    // Mensaje a enviar
    $message_body = "Nombre: $name<br>Email: $email<br>Teléfono: $phone<br>Asunto: $subject<br><br>Mensaje:<br>$message";

    // Intentar enviar el correo
    if (mail($to, $subject, $message_body, implode("\r\n", $headers))) {
        echo "<script>alert('Se ha enviado tu mensaje correctamente.'); window.location.href='../html/contact_us.php';</script>";
        exit;
    } 
}
?>