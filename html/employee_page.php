<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Gestion de Reservas</title>
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
				<a href="#" class="active">
					Inicio
				</a>
				<a href="..\php\employee_add_page.php">
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
					<h2>Ultimas Reservaciones</h2>
					<div class="filter-options">
						<p>Area: <?php echo $area; ?></p>		
					</div>
				</div>
				<!-------------------Division---------------->
				<section class="transfers">
					<div class="transfer-section-header">
						<div class="filter-options">
							<dl class="transfer-details">
								<div>
									<dt>ID de Reserva</dt>
								</div>
								<div>
									<dt>Cliente</dt>
								</div>
								<div>
									<dt>Fecha de la Reserva</dt>
								</div>
								<div>
									<dt>Tipo de Reserva</dt>
								</div>	
								<div>
									<dt>Anticipo</dt>
								</div>
								<div>
									<dt>Hora Inicial</dt>
								</div>
								<div>
									<dt>Hora Final</dt>
								</div>
								<div></div>	
							</dl>
						</div>
					</div>			
				</section>
				<!-----------Apartado de los Resultados---------------------->
				<div class="transfers">
                <?php
                if ($result_reservaciones->num_rows > 0) {
                    while ($fila_reserva = $result_reservaciones->fetch_assoc()) {
                        ?>
                        <div class="transfer">
                            <!-- Transfer Details -->
                            <div class="transfer-logo">
                                <img src="https://clipground.com/images/client-icon-png-4.png" />
                            </div>
                            <dl class="transfer-details">
                                <div>
                                    <dt><?php echo $fila_reserva['ID_Reservacion']; ?></dt>
                                </div>
                                <div>
                                    <dt><?php echo $fila_reserva['NombreCliente'] . ' ' . $fila_reserva['ApellidoCliente']; ?></dt>
                                </div>
                                <div>
                                    <dt><?php echo $fila_reserva['Fecha_Reserva']; ?></dt>
                                </div>
                                <div>
                                    <dt><?php echo $fila_reserva['Tipo_Reserva']; ?></dt>
                                </div>
                                <div>
                                    <dt>$<?php echo $fila_reserva['Anticipo']; ?></dt>
                                </div>
								<div>
								<dt><?php echo $fila_reserva['Hora_Inicio']; ?></dt>
								</div>
								<div>
									<dt><?php echo $fila_reserva['Hora_Final']; ?></dt>
								</div>
								<!------------------BOTONES-------------------->
								<div class="filter-options">
									<dl class="transfer-details">
										<!-------Boton para eliminar la reserva------------->							
										<form method="post" action="../php/employee_delete.php">
											<input type="hidden" name="id_reservacion" value="<?php echo $fila_reserva['ID_Reservacion']; ?>">
											<button type="submit" name="delete_reservation" class="icon-button large">
												<i class="ph ph-user-minus"></i>
											</button>
										</form>
										<!-- Botón para gestionar la reserva -->
										<form method="post" action="../php/employee_modify_page.php">
											<!-- Asegúrate de incluir el ID de la reserva -->
											<input type="hidden" name="id_reservacion" value="<?php echo htmlspecialchars($fila_reserva['ID_Reservacion']); ?>">
											<input type="hidden" name="manage_reservation" value="true">
											<button type="submit" class="icon-button large">
												<i class="ph ph-user-gear"></i>
											</button>
										</form>
									</dl>
								</div>
								<!------------------------------------------------>
                            </dl>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="transfer">
                        <p>No se encontraron reservaciones para el área que administra el empleado.</p>
                    </div>
                    <?php
                }
                ?>
            	</div>
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