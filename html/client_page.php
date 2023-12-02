<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosebrith - Perfil</title>
    <link rel="icon" href="../image/main_icon.png">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/style_client_page.css">
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
        <?php include '..\php\change_button.php';?>
    </header>
    
    <!--------------------BANNER--------------------->
    <div class="banner"></div>

    <!--------------------CONTENIDO--------------------->
    <div class="content">
        <div class="content__title">
            <h2>Reservas anteriores realizadas</h2>
        </div>
        <div class="content__text">
            <?php include '..\php\client_consult.php';?>
            <h2>Bienvenido, <?php echo $nombre_cliente?></h2>
            <br>
            <h3>Tu historial de reservas</h3>
        </div>
    </div>

    <!--------------------TABLA DE RESERVACIONES--------------------->  
    <div class="table">
        <?php include ("..\php\historial_reservacion_cliente.php"); ?>
    </div>

  

</body>
</html>