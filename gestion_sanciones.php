<?php
session_start(); // Aseguramos que la sesión esté iniciada
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Consulta para obtener las reservas junto con los campos sancion y cant_sancion
$sql_reservas = "SELECT id_reserva, fecha_reserva, tipo_reserva, cantidad, sancion, cant_sancion
                 FROM reserva";
$reservas = dbQuery($sql_reservas);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Lista de Reservas</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th># Reserva</th>
                            <th>Fecha de Reserva</th>
                            <th>Tipo de Reserva</th>
                            <th>Cantidad</th>
                            <th>Sanción</th>
                            <th>Cant. Sanción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($reserva = $reservas->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                                <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                                <td><?= htmlspecialchars($reserva['tipo_reserva']) ?></td>
                                <td><?= $reserva['tipo_reserva'] == 'Grupal' ? htmlspecialchars($reserva['cantidad']) : '1' ?></td>
                                <td><?= htmlspecialchars($reserva['sancion'] ?? 'N/A') ?></td>  <!-- Manejamos que puede ser NULL -->
                                <td><?= htmlspecialchars($reserva['cant_sancion'] ?? '0') ?></td>  <!-- Manejamos que puede ser NULL -->
                                <td>
                                    <a href="gestion_sanciones_detalle.php?id_reserva=<?= $reserva['id_reserva'] ?>" class="btn btn-info btn-sm">Ver Detalles</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>
