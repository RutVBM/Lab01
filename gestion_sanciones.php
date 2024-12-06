<?php
session_start(); // Aseguramos que la sesión esté iniciada
include("header.php");
include_once("conexion/database.php");
include("sidebar.php");

// Consulta para obtener las reservas junto con el usuario
$sql_reservas = "SELECT r.id_reserva, r.fecha_reserva, r.tipo_reserva, r.cantidad, r.sancion, r.cant_sancion,
                 u.nombre, u.apellidos
                 FROM reserva r
                 INNER JOIN usuario u ON r.id_usuario = u.idusuario";
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
                            <th>Cliente</th>
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
                                <td><?= htmlspecialchars($reserva['nombre'] . ' ' . $reserva['apellidos']) ?></td>
                                <td><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                                <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                                <td><?= htmlspecialchars($reserva['tipo_reserva']) ?></td>
                                <td><?= $reserva['tipo_reserva'] == 'Grupal' ? htmlspecialchars($reserva['cantidad']) : '1' ?></td>
                                <td><?= htmlspecialchars($reserva['sancion'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($reserva['cant_sancion'] ?? '0') ?></td>
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
