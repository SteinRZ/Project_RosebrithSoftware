<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Agregar una Cita</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="../css/style_employee_page.css">
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
				<center>
				<form method="post" action="../php/employee_insert.php">
					<h1>Nombre del Cliente:</h1>
					<input type="text" name="nombre_cliente" required>

					<h1>Apellido Paterno:</h1>
					<input type="text" name="apellido_paterno" required>

					<h1>Apellido Materno:</h1>
					<input type="text" name="apellido_materno" required>

					<h1>Tipo de Reservacion:</h1>
					<select id="tipo_reserva" name="tipo_reserva" required>
						<option value="Alberca">Alberca</option>
						<option value="Salón">Salón</option>
						<option value="Ambos">Ambos</option>
					</select>
					
					<h1>Teléfono:</h1>
					<input type="tel" name="telefono_cliente" required>

					<h1>Fecha de Reservación:</h1>
					<input type="date" name="fecha_reservacion" required>

					<h1>Hora de Inicio:</h1>
					<input type="time" name="hora_inicio" required>

					<h1>Hora de Finalización:</h1>
					<input type="time" name="hora_final" required>

					<h1>Anticipo:</h1>
					<input type="text" name="anticipo" required>

					<br><button class="flat-button" type="submit" name="agregar_cita">Agregar Cita</button></br>
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
