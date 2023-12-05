<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// CONFIGURACION DE LA BASE DE DATOS
include 'db_config.php';

// CONSULTA DE CLIENTE
$id_usuario = mysqli_real_escape_string($conn, $_SESSION['id_usuario']);

$sql_cliente = "SELECT * FROM Cliente WHERE ID_Usuario = '$id_usuario'";
$result_cliente = $conn->query($sql_cliente);

if ($result_cliente->num_rows > 0) {
  // Si el usuario está almacenado como cliente, muestra el historial de reservaciones
  $sql_reservaciones = "SELECT r.ID_Reservacion, r.Fecha_Reserva, r.Tipo_Reserva, r.Hora_Inicio, r.Hora_Finalizado, r.Total, r.TotalCambiado
                        FROM Usuario u 
                        INNER JOIN Cliente c ON u.ID_Usuario = c.ID_Usuario 
                        LEFT JOIN Reservacion r ON c.ID_Cliente = r.ID_Cliente 
                        WHERE u.ID_Usuario = '$id_usuario'";

  $result_reservaciones = $conn->query($sql_reservaciones);

  if ($result_reservaciones->num_rows > 0) {
    echo "<table>
            <tr>
              <th>Numero de reservación</th>
              <th>Fecha de la reservacion</th>
              <th>Tipo de reservacion</th>
              <th>Hora de inicio de evento</th>
              <th>Hora de conclusion de evento</th>
              <th>Costo del evento</th>
              <th>Total que falta a pagar</th>
            </tr>";

    // Salida de cada fila
    while ($row = $result_reservaciones->fetch_assoc()) {
      echo "<tr><td>".$row["ID_Reservacion"].
            "</td><td>".$row["Fecha_Reserva"].
            "</td><td>".$row["Tipo_Reserva"].
            "</td><td>".$row["Hora_Inicio"].
            "</td><td>".$row["Hora_Finalizado"].
            "</td><td>".$row["Total"].
            "</td><td>".$row["TotalCambiado"].
            "</td></tr>";
    }
    echo "</table>";
  } else {
    echo "No has realizado ninguna reservación, te invitamos a que realices una reservación.";
  }
} else {
  // Si el usuario no está almacenado como cliente, redirige al inicio de sesión
  header("Location: ../html/login.php");
  exit();
}

// CERRAR CONEXION
$conn->close();
?>