<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosebrith | Reserva</title>
    <link rel="icon" href="../image/main_icon.png">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/style_reserve.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap">
</head>
<body>
<?php
    // Incluir el archivo donde se obtiene la información del cliente
    include '..\php\client_consult.php';
?>
    <!--------------------NAVBAR--------------------->
    <header class="navbar">
        <div class="navbar__icon">
            <a href="main.php"><img src="../image/main_icon.png" alt="Rosebrith" title="Inicio"></a>
        </div>
        <nav>
           <ul class="nav__links">
                <li><a href="services.php">Servicios</a></li>
                <li><a href="contact_us.php">Contactanos</a></li>
           </ul>            
        </nav>
        <?php include '..\php\change_button.php';?>
    </header>

    <section class="reservation-section">
        <h2>Reserva</h2>
        <form method="post" action="../php/reserve_client.php">
        <label for="tipo_reserva">Tipo de Reservacion:</label>
        <select id="tipo_reserva" name="tipo_reserva" required>
            <option value="Alberca">Alberca</option>
            <option value="Salón">Salón</option>
            <option value="Ambos">Ambos</option>
        </select>

        <label for="telefono_cliente">Teléfono:</label>
        <input type="tel" id="telefono_cliente" name="telefono_cliente" required>

        <label for="fecha_reservacion">Fecha de Reservación:</label>
        <input type="date" id="fecha_reservacion" name="fecha_reservacion" required>

        <label for="hora_inicio">Hora de Inicio:</label>
        <input type="time" id="hora_inicio" name="hora_inicio" required>

        <label for="hora_final">Hora de Finalización:</label>
        <input type="time" id="hora_final" name="hora_final" required>

        <label for="anticipo">Anticipo:</label>
        <input type="text" id="anticipo" name="anticipo" required>

        <button class="btn" id="btn_reserva" type="submit" name="agregar_reserva">Reservar</button>
        </form>
    </section>
</body>
</html>
