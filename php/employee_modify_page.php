<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Agregar una Cita</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="..\css\style_employee.css">
</head>
<body>
<?php
    // Incluir el archivo donde se obtiene la información del empleado
    include '..\php\employee.php';
?>
<div class="app">
	<!-----------------------------------HEADER----------------------->
	<header class="app-header">
		<div class="app-header-logo">
			<div class="logo">
				<span class="logo-icon">
					<img src="../image/main_icon.png" />
				</span>
				<h1 class="logo-title">
					<span>Rosebrith</span>
					<span>Alberca y Salón</span>
				</h1>
			</div>
		</div>
		<div class="app-header-navigation">
			<div class="tabs">
				<a href="..\html\employee_page.php">
					Inicio
				</a>
				<a href="#" class="active">
					Agendar Cita
				</a>
			</div>
		</div>
		<div class="app-header-actions">
			<button class="user-profile">
				<span><?php echo $nombre_empleado . ' ' . $apellido_paterno; ?></span>
				<span>
					<img src="https://www.vhv.rs/dpng/d/436-4363443_view-user-icon-png-font-awesome-user-circle.png"/>
				</span>
			</button>
			<div class="app-header-actions-buttons">
				<a href="..\php\logout.php" class="icon-button large">
					<i class="ph-sign-out"></i>
				</a>
			</div>
		</div>
	</header>
	<!------------------------------------------------------------->
	<div class="app-body">
        <!-------------------Reservacion HEADER-------------------->
		<div class="app-body-main-content">
			<section class="transfer-section">
				<div class="transfer-section-header">
					<h2>Rellenar el Formulario</h2>
					<div class="filter-options">
						<p>Area: <?php echo $area; ?></p>		
					</div>
				</div>
				<!-----------Agregar Citas---------------------->
				<section class="service-section">
				<div class="service-section-header">
                <?php
                    // Incluir el archivo donde se obtiene la información del empleado
                    include '..\php\employee_consult.php';
                ?>
				<center>
                <form method="post" action="../php/employee_modify.php">
					<input type="hidden" name="id_reservacion" value="<?php echo $id_reservacion; ?>">
                    <h1>Nombre del Cliente:</h1>
                    <input type="text" name="nombre_cliente" value="<?php echo isset($nombre_cliente) ? htmlspecialchars($nombre_cliente) : ''; ?>" required>

                    <h1>Apellido Paterno:</h1>
                    <input type="text" name="apellido_paterno" value="<?php echo isset($apellido_paterno) ? htmlspecialchars($apellido_paterno) : ''; ?>" required>

                    <h1>Apellido Materno:</h1>
                    <input type="text" name="apellido_materno" value="<?php echo isset($apellido_materno) ? htmlspecialchars($apellido_materno) : ''; ?>" required>

                    <h1>Tipo de Reservacion:</h1>
                    <select id="tipo_reserva" name="tipo_reserva" required>
                        <option value="Alberca" <?php echo ($tipo_reserva === 'Alberca') ? 'selected' : ''; ?>>Alberca</option>
                        <option value="Salon" <?php echo ($tipo_reserva === 'Salón') ? 'selected' : ''; ?>>Salón</option>
                        <option value="Ambos" <?php echo ($tipo_reserva === 'Ambos') ? 'selected' : ''; ?>>Ambos</option>
                    </select>

                    <h1>Teléfono:</h1>
                    <input type="tel" name="telefono_cliente" value="<?php echo isset($telefono_cliente) ? htmlspecialchars($telefono_cliente) : ''; ?>" required>

                    <h1>Fecha de Reservación:</h1>
                    <input type="date" name="fecha_reservacion" value="<?php echo isset($fecha_reservacion) ? htmlspecialchars($fecha_reservacion) : ''; ?>" required>

                    <h1>Hora de Inicio:</h1>
                    <input type="time" name="hora_inicio" value="<?php echo isset($hora_inicio) ? htmlspecialchars($hora_inicio) : ''; ?>" required>

                    <h1>Hora de Finalización:</h1>
                    <input type="time" name="hora_final" value="<?php echo isset($hora_final) ? htmlspecialchars($hora_final) : ''; ?>" required>

                    <h1>Anticipo:</h1>
                    <input type="text" name="anticipo" value="<?php echo isset($anticipo) ? htmlspecialchars($anticipo) : ''; ?>" required>
					<br>
                    <br><button class="flat-button" type="submit" name="modificar_cita">Modificar</button><br>
                </form>
				</center>
				<!---------------------------------------------------------->
			</section>
		</div>
		<!--------------------------------------------------------->
	</div>
</div>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>

</body>
</html>
