<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosebrith | Login</title>
    <link rel="icon" href="../image/main_icon.png">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/style_login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <div class="fondo__login">
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
        </header>
        <!-----------------------LOGIN/SIGNUP----------------->
        <div class="main">  	
            <input type="checkbox" id="chk" aria-hidden="true">
            <!----------------INICIARSESION----------------->
                <div class="login">
                    <form name="sesion" method = "POST">
                        <?php 
                        include ("..\php\iniciar_sesion.php")
                        
                        ?>
                        <label for="chk" aria-hidden="true">Iniciar Sesíon</label>
                        <input type="email" name="email2" placeholder="Correo" required="">
                        <input type="password" name="pswd2" placeholder="Contraseña" required="">           
                        <button type="submit" name="iniciar_sesion">Entrar</button>
                    </form>
                </div>
            <!-----------------CREARCUENTA-------------->
                <div class="signup">
                    <form name="registro" method="POST">
                        <?php 
                        include ("..\php\insertar_cliente.php")
                        ?>
                        <label for="chk" aria-hidden="true">Crear Cuenta</label>
                        <input type="name" name="name" placeholder="Nombre" required="">
                        <input type="lname" name="apellidoP" placeholder="Apellido Paterno" required="">
                        <input type="lname" name="apellidoM" placeholder="Apellido Materno" required="">
                        <input type="email" name="email" placeholder="Correo" required="">
                        <input type="tel" name="telefono" placeholder="Telefono" required="" pattern="[0-9]{10}">
                        <input type="password" name="pswd" placeholder="Contraseña" required="">
                        <input type="password" name="confirmpswd" placeholder="Confirmar Contraseña" required="">
                        <button type="submit" name="crear_cuenta">Registrarse</button>
                    </form>
                </div>
                <script src="../js/login.js"></script>
        </div>
    </div>
</body>
</html>