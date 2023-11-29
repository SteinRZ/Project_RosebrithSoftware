<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Rosebrith</title>
    <link rel="icon" href="../image/main_icon.png">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/style_contact_us.css">
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

    <!--------------------FORM--------------------->
        <form id="contactForm" method="post" action="../php/send_email.php">
        <div class="form">
            <div>
                <h2>Contáctanos</h2>
            </div>
            <div>
                <p>En Rosebrith es un placer ayudarte, para cualquier aclaración o duda envíala aquí y nosotros nos pondremos en contacto.</p>
            </div>
            <div>
                <div>
                    <label for="field__name">Nombre:</label>
                </div>
                <div>
                    <input type="text" name="field__name" id="field__name">
                </div>
            </div>
            <div>
                <div>
                    <label for="field__email">Correo electrónico:</label>
                </div>
                <div>
                    <input type="text" name="field__email" id="field__email">
                </div>
            </div>
            <div>
                <div>
                    <label for="field__phone">Teléfono:</label>
                </div>
                <div>
                    <input type="text" name="field__phone" id="field__phone">
                </div>
            </div>
            <div>
                <div>
                    <label for="field__affair">Asunto:</label>
                </div>
                <div>
                    <input type="text" name="field__affair" id="field__affair">
                </div>
            </div>
            <div class="form__message">
                <div>
                    <label for="field__message">Mensaje:</label>
                </div>
                <div>
                    <textarea name="field__message" class="form__message--input" id="field__message" cols="15" rows="5"></textarea>
                </div>
                <div class="form__send">
                    <button type="submit" class="form__send--button">Enviar</button>
                </div>
            </div>
        </div>
    </form>
    </div>

    <!--------------------INFORMATION--------------------->
    <div class="information">
        <div class="information__contact--direct">
            <h3>
                Contacto directo
            </h3>
            <p>
                Telefono:
            </p>
            <p>
                Whatsapp:
            </p>
            <p>
                Correo:
            </p>
        </div> 
        <div class="information__ubication">
            <h3>
                Ubicación
            </h3>
            <p>
                Ubicacion de rosebrith.
            </p>
        </div>
    </div>
</body>
</html>