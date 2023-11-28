<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Rosebrith | Servicios</title>
    <link rel="icon" href="../image/main_icon.png">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/style_service.css">
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
    
<script src="../js/ServiceCarrusel.js"></script>
<div class="content__text">
    <h3>¡Bienvenido a Rosebrith Servicios!</h3>
    <p>Sumérgete en la serenidad de nuestra alberca, un oasis que combina relajación y diversión.</p>
</div>
<div id="contenedor1">
<button id="prev" onclick="prevSlide()">&#10094;</button>
<div id="carousel-container">
    <div id="carousel">
        <div class="slide"><img src="../image/img_pool_1.jpg" alt="Slide 1"></div>
        <div class="slide"><img src="../image/img_pool_2.jpg" alt="Slide 2"></div>
        <div class="slide"><img src="../image/parrilla.jpg" alt="Slide 3"></div>
        <div class="slide"><img src="../image/img_eventhall_1.jpg" alt="Slide 2"></div>
    </div>
</div>
<button id="next" onclick="nextSlide()">&#10095;</button>
<div id="contenedor3">
<div class="menu">
    <a onclick="mostrarContenido('servicios')">Servicios</a>
    <a onclick="mostrarContenido('precios')">Precios</a>
</div>
<div id="servicios" class="content">
    <h3>Nuestros servicios</h3>
    <p>Nuestro espacio único ofrece un ambiente perfecto para disfrutar de momentos inolvidables.
    
        En Rosebrith, no solo contamos con una espléndida alberca, sino que también te brindamos acceso a un elegante salón, una moderna parrilla para tus eventos culinarios y una encantadora alberca infantil. Diseñado para satisfacer todas tus necesidades, nuestro conjunto de servicios te invita a vivir experiencias excepcionales.
        
        Descubre el equilibrio perfecto entre lujo y comodidad en Rosebrith. ¡Esperamos ser parte de tus recuerdos inolvidables!</p>
</div>
<div id="precios" class="content">
    <h3>Nuestros precios</h3>
      <p>
            Lunes - Jueves  $1800 <br>
            Viernes $2800 <br>
            Sabado y Domingo $3800 <br>
            x 6 horas  con limite 10pm <br>
            Hora extra $600 <br>
            Si el horario pasa de las 10pm cada hora $600 <br>
      </p>
</div>

</div>
<!-- contenedor 1 -->

</div>

<div id="contenedor2">
    <button id="prev" onclick="prevSlide2()">&#10094;</button>
    <div id="carousel-container">
        <div id="carousel2">
            <div class="slide"><img src="../image/img_eventhall_2.jpg" alt="Slide 1"></div>
            <div class="slide"><img src="../image/img_eventhall_1.jpg" alt="Slide 2"></div>
            <div class="slide"><img src="../image/img_eventhall_2.jpg" alt="Slide 3"></div>
            <div class="slide"><img src="../image/img_eventhall_1.jpg" alt="Slide 2"></div>
        </div>
    </div>
    <button id="next" onclick="nextSlide2()">&#10095;</button>
    
</div>

</body>
</html>
