<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Rosebrith</title>
    <link rel="icon" href="../image/main_icon.png">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/style_main.css">
</head>

<body>
    <!--------------------NAVBAR--------------------->
    <header class="navbar">
        <div class="navbar__icon">
            <a href="#contenido"><img src="../image/main_icon.png" alt="Rosebrith" title="Inicio"></a>
        </div>
        <nav>
           <ul class="nav__links">
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#contactanos">Contactanos</a></li>
           </ul>            
        </nav>
        <?php include '../php/change_button.php';?>
    </header>
    
    <!--------------------CONTENT--------------------->
    <div class="contenido" id="contenido">
        <div class="contenido_imagen">
            <img src="../image/main_icon.png" alt="Rosebrith" class="img">
        </div>
        <div class="contenido__titulo">
            <h3>Bienvenido a Rosebrith</h3>
        </div>
        <div class="contenido__texto">
            <p>Disfruta de un dia especial junto con nosotros en nuestro grandioso salon o nuestra grandiosa alberca.</p>
        </div>
        <div class="contenido__texto--2">
            <p>Contacta con nosotros y crea una reservacion ahora mismo con nosotros.</p>
        </div>
    </div>
    
    <!--------------------SERVICES-------------------->
    <div class="servicios" id="servicios">
        <div class="servicios__titulo">
            <h3>Nuestros servicios</h3>
        </div>
        <div class="servicios__texto">
            <p>En Rosebrith, distruta de un dia especial en nuestro salon de eventos para hasta 60 personas o de nuestra grandiosa alberca.</p>
        </div>
        <div class="servicios__imagenes">
            <div class="servicios__imagenes--1">
                <img src="../image/img_pool_1.jpg" alt="Imagen alberca" class="img2">
            </div>
            <div class="servicios__imagenes--2">
                <img src="../image/img_pool_2.jpg" alt="Imagen alberca" class="img2">
            </div>
            <div class="servicios__imagenes--3">
                <img src="../image/img_eventhall_1.jpg" alt="Imagen alberca" class="img2">
            </div>
            <div class="servicios__imagenes--4">
                <img src="../image/img_eventhall_2.jpg" alt="Imagen alberca" class="img2">
            </div>
        </div>
        <div class="servicios__texto">
            <p>Disfruta tu siguiente experencia con nosotros con nuestros precios:</p>
            <br>
            <h3>Alberca y Salon:</h3>
            <p>Lunes a Jueves - $1800</p>
            <p>Viernes - $2800</p>
            <p>Sabado y Domingo - $3800</p>
            <br>
            <h3>Solo alberca:</h3>
            <p>Lunes a Jueves - $900</p>
            <p>Viernes - $1400</p>
            <p>Sabado y Domingo - $1900</p>
            <br>
            <h3>Solo salon:</h3>
            <p>Lunes a Jueves - $900</p>
            <p>Viernes - $1400</p>
            <p>Sabado y Domingo - $1900</p>
            <br>
            <p>Esto por 6 horas con un limite de hasta las 10pm.</p>
            <p>Aclaracion: Si el evento pasa de las 10:00pm, las horas extras se cobraran $600 cada hora.</p>
        </div>
    </div>

    <!--------------------CONTACT-------------------->
    <div class="contactanos" id="contactanos">
        <div class="contactanos__titulo">
            <h3>Contactanos</h3>
        </div>
        <p>
            Telefono: +52 867 299 1978
        </p>
        <p>
            Whatsapp: +52 867 299 1978
        </p>
        <p>
            Correo: rosebrith@outlook.com
        </p>
        <p>
            Donde encontrarnos: Colonia Union del Recuerdo, Calle Recuerdo Ave La Cruz #812
        </p>
    </div>
</body>
</html>