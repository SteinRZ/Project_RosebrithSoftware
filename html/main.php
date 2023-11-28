<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosebrith | Inicio</title>
    <link rel="icon" href="../image/main_icon.png">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/style_main.css">
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
    
    <!--------------------CONTENT--------------------->
    <div class="content" id="content">
        <div class="content__image">
            <img src="../image/main_icon.png" alt="Rosebrith" class="img">
        </div>
        <div class="content__title">
            <h3>Reserva tu cita con nosotros</h3>
        </div>
        <div class="content__text">
            <p>Disfruta de un dia refrescante reservando tu cita en Rosebrith.</p>
        </div>
        <div class="content__button">
            <a href="reserve.php"><button class="content__button--button" id="btn_reserva">¡Reserva ahora!</button></a>
        </div>
    </div>
    
    <!--------------------SERVICES-------------------->
    <!----------BACKGROUND--------->
    <div class="ocean">
        <!-------IMAGES CONTENT------------->
        <div class="services">
            <div class="services_title"> 
                <h2>Nuestros Servicios</h2>
            </div>
            <div class="services_image">         
            <!---------------POOL------------->  
                <article class="card">
                    <img class="card__background" src="../image/img_pool_1.jpg" alt="Alberca">
                    <div class="card__content | flow">
                        <div class="card__content--container | flow">
                            <h2 class="card__title">Alberca</h2>
                            <p class="card__description">Pasa con nosotros un dia refrescante en nuestra gran Alberca.</p>
                        </div>
                        <a href="services.php"><button class="card__button">Conoce más</button></a href>
                    </div>
                </article>
                <!-------------LOUNGE----------->
                <article class="card">
                    <img class="card__background" src="../image/img_eventhall_2.jpg" alt="Salon">
                    <div class="card__content | flow">
                        <div class="card__content--container | flow">
                            <h2 class="card__title">Salon</h2>
                            <p class="card__description">Pasa con nosotros tu evento más importante en nuestro gran Salon.</p>
                        </div>
                        <a href="services.php"><button class="card__button">Conoce más</button></a href>
                    </div>
                </article>
            <!--------------END IMAGE CARDS---------------------->   
            </div>
        </div>
        <div class="bubble bubble--1"></div>
        <div class="bubble bubble--2"></div>
        <div class="bubble bubble--6"></div>
        <div class="bubble bubble--1"></div>
        <div class="bubble bubble--2"></div>
        <div class="bubble bubble--3"></div>
        <div class="bubble bubble--7"></div>
        <!---------------END IMAGES CONTENT-->
    </div>
    <!---END BACKGROUND-->
</body>
</html>