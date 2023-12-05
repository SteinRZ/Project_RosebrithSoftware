<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rosebrith - Empleado</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/stye_employee-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

</head>

<body id="page-top">
<?php
    // Incluir el archivo donde se obtiene la información del empleado
    include '../php/employee.php';
?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../html/employee_page.php">
                <div class="sidebar-brand-icon">
                        <i class="fas fa-droplet"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Gestión Rosebrith</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="../html/employee_page.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tabla de Reservaciones</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Agendar una Cita</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../php/employee_page_add.php">Cliente Nuevo</a>
                        <a class="collapse-item" href="#">Cliente Existente</a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nombre_empleado . ' ' . $apellido_paterno; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="https://clipground.com/images/client-icon-png-4.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Agendar una Cita</h1>
                    <p class="mb-4">Agenda una cita de un cliente ya registrado. Recuerda que si estas en una área determinada y lo agendas en otra área no te aparecera la reserva.</p>
                    <p class="mr-4">El área que administras es: <b><?php echo $area; ?></b></p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Reservaciones de <?php echo $area; ?> </h6>
                        </div>
                        <center>
                        <form method="post" action="../php/employee_insert_existing.php">
                        <?php
                            include '../php/employee_consult.php';
                        ?>
                        <h4>Nombre del Cliente:</h4>
                        <select id="id_cliente" name="id_cliente" required>
                            <option value="" selected disabled>Selecciona el nombre del cliente</option>
                            <?php 
                            if ($result_clientes && $result_clientes->num_rows > 0) {
                                while ($row = $result_clientes->fetch_assoc()) {
                                    echo "<option value='" . $row['ID_Cliente'] . "'>" . $row['Nombre'] . "</option>";
                                }
                            } 
                            ?>
                        </select>
                            <hr class="sidebar-divider d-none d-md-block">
                            <h4>Apellido Paterno del Cliente:</h4>
                            <script src="../js/lastname.js"></script>
                            <input type="text" id="apellido_paterno" name="apellido_paterno" readonly>                   
                            <hr class="sidebar-divider d-none d-md-block">
                            <h4>Apellido Materno del Cliente:</h4>
                            <script src="../js/second_lastname.js"></script>
                            <input type="text" id="apellido_materno" name="apellido_materno" readonly>
                            <hr class="sidebar-divider d-none d-md-block">
                            <h4>Tipo de Reservacion:</h4>
                            <select id="tipo_reserva" name="tipo_reserva" required>
                                <option value="" disabled selected>Elegir el tipo de reserva</option>
                                <option value="Alberca">Alberca</option>
                                <option value="Salón">Salón</option>
                                <option value="Ambos">Ambos</option>
                            </select>
                            <hr class="sidebar-divider d-none d-md-block">
                            <h4>Fecha de Reservación:</h4>
                            <input type="date" name="fecha_reservacion" required>
                            <hr class="sidebar-divider d-none d-md-block">
                            <h4>Hora de Inicio:</h4>
                            <input type="time" name="hora_inicio" required>
                            <hr class="sidebar-divider d-none d-md-block">
                            <h4>Hora de Finalización:</h4>
                            <input type="time" name="hora_final" required>
                            <hr class="sidebar-divider d-none d-md-block">
                            <h4>Anticipo:</h4>
                            <input type="text" name="anticipo" value="600" readonly>
                            <hr class="sidebar-divider d-none d-md-block">
                            <button class="btn btn-info" type="submit" name="agregar_cita_existente">Agregar Cita</button>
                        </form>
				        </center>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CerrarSesión</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">¿Estas seguro de cerrar la sesión?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="../php/logout.php">Salir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

</body>
</html>