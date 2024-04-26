<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rosebrith - Administrador</title>

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
    include '../php/employee.php';
    include '../php/admin_tables_consult.php';
?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../html/admin_page.php">
            <div class="sidebar-brand-icon">
                    <i class="fas fa-droplet"></i>
            </div>
                <div class="sidebar-brand-text mx-3">Administración Rosebrith</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tablas</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../html/admin_page.php">Usuarios</a>
                        <a class="collapse-item " href="../php/admin_table_employee.php">Empleados</a>
                        <a class="collapse-item " href="../php/admin_table_client.php">Clientes</a>
                        <a class="collapse-item active" href="#">Reservaciones</a>
                    </div>
                </div>
            </li>
             <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="../php/admin_registrar_Empleado.php">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Registrar Empleado</span></a>
            </li>

            <!-- Nav Item - Chart Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-chart-simple"></i>
                    <span>Gráficas</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../php/admin_graphic.php">Grafica de Usuarios</a>
                        <a class="collapse-item" href="../php/admin_graphic2.php">Grafica de Reservaciones</a>
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrador</span>
                                <img class="img-profile rounded-circle"
                                    src="https://icon-library.com/images/admin-icon/admin-icon-4.jpg">
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
                    <h1 class="h3 mb-2 text-gray-800">Tabla de Reservaciones</h1>
                    <p class="mb-4">Se mostraran todas las reservaciones registrados y alamacenados en la base de datos.</p>
                    
                    <!--Boton para generar reportes-->
                    <div style="text-align:center; padding-bottom: 20px">
                        <p class="mb-4">Selecciona una opcion para generar un reporte.</p>
                        <div style="display: flex; justify-content: center; gap: 10px;">
                            <form method="post" action="generar_reporte.php">
                                <select name="opciones">
                                    <option value="Alberca">Alberca</option>
                                    <option value="Salon">Salon</option>
                                    <option value="Ambos">Ambos</option>
                                </select>
                                <button type="submit" class="btn btn-primary" name="reporte">Generar reporte</button>
                            </form>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Reservaciones Registrados</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <form action='../php/guardar_cambios_Reservacion.php' method='post'>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th>ID de Reservacion</th>
                                        <th>ID de Cliente</th>
                                        <th>Fecha de Reserva</th>
                                        <th>Tipo de Reserva</th>
                                        <th>Anticipo</th>
                                        <th>Hora de Inicio</th>
                                        <th>Hora de Finalizado</th>
                                        <th>Duración</th>
                                        <th>Total</th>
                                        <th>Comentario</th>
                                        <th>Fecha de Creación</th>
                                        <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>ID de Reservacion</th>
                                        <th>ID de Cliente</th>
                                        <th>Fecha de Reserva</th>
                                        <th>Tipo de Reserva</th>
                                        <th>Anticipo</th>
                                        <th>Hora de Inicio</th>
                                        <th>Hora de Finalizado</th>
                                        <th>Duración</th>
                                        <th>Total</th>
                                        <th>Pendiente a pagar</th>
                                        <th>Comentario</th>
                                        <th>Fecha de Creación</th>
                                        <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                            while ($row = $result_reservacion->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <td><?php echo "<input type='hidden' name='ID_Reservacion[]' value='" . $row['ID_Reservacion'] . "'>" . $row['ID_Reservacion']; ?></td>
                                                    <td><span><?php echo $row['ID_Cliente']; ?></span></td>
                                                    <td><input type='text' name='Fecha_Reserva[]' value='<?php echo $row['Fecha_Reserva']; ?>'></td>
                                                    <td><input type='text' name='Tipo_Reserva[]' value='<?php echo $row['Tipo_Reserva']; ?>'></td>
                                                    <td><input type='text' name='Anticipo[]' value='<?php echo $row['Anticipo']; ?>'></td>
                                                    <td><input type='text' name='Hora_Inicio[]' value='<?php echo $row['Hora_Inicio']; ?>'></td>
                                                    <td><input type='text' name='Hora_Finalizado[]' value='<?php echo $row['Hora_Finalizado']; ?>'></td>
                                                    <td><input type='text' name='Duracion[]' value='<?php echo $row['Duracion']; ?>'></td>
                                                    <td><input type='text' name='Total[]' value='<?php echo $row['Total']; ?>'></td>
                                                    <td><input type='text' name='Comentario[]' value='<?php echo $row['Comentario']; ?>'></td>
                                                    <td><span><?php echo $row['Fecha_Creacion']; ?></span></td>
                                                    <td>
                                                        <div class="d-flex justify-content-between">
                                                            <button type="submit" class="btn btn-primary btn-circle" name="guardar_reservacion"><i class="fas fa-fw fa-floppy-disk"></i></button>
                                                            <button type='submit' class="btn btn-danger btn-circle" formaction='../php/admin_eliminar_Reservacion.php' name='Reservacion' value='<?php echo $row['ID_Reservacion']; ?>'><i class="fas fa-fw fa-trash"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                            if ($result_reservacion->num_rows == 0) {
                                        ?>
                                                <tr>
                                                    <td colspan="11">No se encontraron reservaciones.</td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                            </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Cerrar Sesión</h5>
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