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
        <a class="navbar__button" href="login.php"><button>Iniciar sesion</button></a>
    </header>

    <section class="reservation-section">
        <h2>Reserva</h2>
        <form action="procesar_reserva.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>

            <label for="tipo_reserva">Tipo de Reserva:</label>
            <select id="tipo_reserva" name="tipo_reserva" required>
                <option value="alberca">Alberca</option>
                <option value="salon">Salón de Fiestas</option>
                <option value="ambos">Ambos</option>
            </select>

            <label for="fecha">Fecha de Reserva:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="comentarios">Comentarios adicionales:</label>
            <textarea id="comentarios" name="comentarios" rows="4"></textarea>

            <button class="btn" id="btn_reserva" type="submit">Reservar</button>
        </form>
    </section>
</body>
</html>
